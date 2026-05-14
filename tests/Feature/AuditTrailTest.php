<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * Phase 2: confirm the Blameable + activity-log behaviour actually
 * fires on a real clinical model.
 */
class AuditTrailTest extends TestCase
{
    use RefreshDatabase;

    private function actingUser(): User
    {
        // Make sure at least a single Role row exists so the auth-gates
        // middleware doesn't blow up if a future test logs the user in
        // and hits a protected route. Tests in this file don't actually
        // hit routes; we just exercise the model layer.
        $role = Role::firstOrCreate(['title' => 'Admin']);

        $user = User::factory()->create();
        $user->roles()->sync([$role->id]);

        return $user;
    }

    public function test_creating_a_customer_stamps_created_by_from_auth(): void
    {
        $user = $this->actingUser();
        Auth::login($user);

        $customer = Customer::create([
            'name' => 'Test Patient',
            'sex' => 'M',
            'province_id' => 1,
            'district_id' => 1,
            'commune_id' => 1,
            'village_id' => 1,
        ]);

        $this->assertSame($user->id, $customer->created_by, 'created_by should equal the authenticated user.');
        $this->assertSame($user->id, $customer->updated_by, 'updated_by should equal the authenticated user on create.');
        $this->assertNull($customer->deleted_by);
        $this->assertNull($customer->deleted_at);
    }

    public function test_updating_a_customer_stamps_updated_by_from_auth(): void
    {
        $creator = $this->actingUser();
        Auth::login($creator);
        $customer = Customer::create([
            'name' => 'Test Patient',
            'sex' => 'M',
            'province_id' => 1,
            'district_id' => 1,
            'commune_id' => 1,
            'village_id' => 1,
        ]);
        Auth::logout();

        $editor = $this->actingUser();
        Auth::login($editor);
        $customer->update(['name' => 'New Name']);

        $this->assertSame($creator->id, $customer->fresh()->created_by);
        $this->assertSame($editor->id, $customer->fresh()->updated_by);
    }

    public function test_deleting_a_customer_soft_deletes_and_stamps_deleted_by(): void
    {
        $creator = $this->actingUser();
        Auth::login($creator);
        $customer = Customer::create([
            'name' => 'Test Patient',
            'sex' => 'M',
            'province_id' => 1,
            'district_id' => 1,
            'commune_id' => 1,
            'village_id' => 1,
        ]);

        $deleter = $this->actingUser();
        Auth::login($deleter);
        $customer->delete();

        // Row is still in the database (soft-delete) but hidden by default.
        $this->assertSoftDeleted($customer);

        $reloaded = Customer::withTrashed()->find($customer->id);
        $this->assertNotNull($reloaded);
        $this->assertNotNull($reloaded->deleted_at);
        $this->assertSame($deleter->id, $reloaded->deleted_by);

        // Restore should clear deleted_at; deleted_by stays as a historical
        // breadcrumb because nothing observably "undoes" the audit event.
        $reloaded->restore();
        $this->assertNull($reloaded->fresh()->deleted_at);
    }

    public function test_activity_log_captures_create_update_delete_events(): void
    {
        $user = $this->actingUser();
        Auth::login($user);

        $customer = Customer::create([
            'name' => 'Test Patient',
            'sex' => 'M',
            'province_id' => 1,
            'district_id' => 1,
            'commune_id' => 1,
            'village_id' => 1,
        ]);

        $customer->update(['name' => 'Renamed']);
        $customer->delete();

        $events = ActivityLog::query()
            ->where('subject_type', Customer::class)
            ->where('subject_id', $customer->id)
            ->orderBy('id')
            ->pluck('event')
            ->all();

        // saveQuietly on the deleted_by stamp intentionally suppresses an
        // additional "updated" event — we don't want every soft-delete to
        // produce two log rows.
        $this->assertSame(['created', 'updated', 'deleted'], $events,
            'Expected one log entry per logical action (create, rename, soft-delete).');
    }
}
