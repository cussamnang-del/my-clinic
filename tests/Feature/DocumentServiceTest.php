<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Document;
use App\Models\User;
use App\Services\DocumentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DocumentServiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeCustomer(): Customer
    {
        // The legacy customers table has multiple NOT NULL columns and
        // FK targets that aren't relevant to this service; bypass FK
        // checks for the fixture and provide the minimum the column
        // definitions require.
        DB::statement('PRAGMA foreign_keys = OFF');

        return Customer::create([
            'name' => 'Test Patient',
            'sex' => 'M',
            'phone_no' => '0123456789',
            'register_date' => now(),
            'province_id' => 0,
            'district_id' => 0,
            'commune_id' => 0,
            'village_id' => 0,
        ]);
    }

    public function test_create_or_update_creates_a_new_document_owned_by_current_user(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $customer = $this->makeCustomer();
        $svc = app(DocumentService::class);

        $doc = $svc->createOrUpdate([
            'customer_id' => $customer->id,
            'visit_date' => '2026-05-14 10:00:00',
            'status' => true,
        ]);

        $this->assertNotNull($doc->id);
        $this->assertSame($user->id, (int) $doc->user_id);
        $this->assertSame($customer->id, (int) $doc->customer_id);
        $this->assertTrue((bool) $doc->status);
    }

    public function test_create_or_update_updates_existing_document_when_id_is_supplied(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $customer = $this->makeCustomer();
        $svc = app(DocumentService::class);

        $doc = $svc->createOrUpdate([
            'customer_id' => $customer->id,
            'visit_date' => '2026-05-14 10:00:00',
            'status' => false,
        ]);

        $updated = $svc->createOrUpdate([
            'id' => $doc->id,
            'customer_id' => $customer->id,
            'visit_date' => '2026-05-14 12:00:00',
            'status' => true,
        ]);

        $this->assertSame($doc->id, $updated->id);
        $this->assertTrue((bool) $updated->status);
    }

    public function test_change_status_returns_false_for_unknown_document_and_true_for_existing(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $customer = $this->makeCustomer();
        $svc = app(DocumentService::class);

        $doc = $svc->createOrUpdate([
            'customer_id' => $customer->id,
            'visit_date' => '2026-05-14 10:00:00',
            'status' => false,
        ]);

        $this->assertFalse($svc->changeStatus(999999, true));
        $this->assertTrue($svc->changeStatus($doc->id, true));
        $this->assertTrue((bool) Document::find($doc->id)->status);
    }

    public function test_delete_soft_deletes_the_document(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $customer = $this->makeCustomer();
        $svc = app(DocumentService::class);

        $doc = $svc->createOrUpdate([
            'customer_id' => $customer->id,
            'visit_date' => '2026-05-14 10:00:00',
            'status' => true,
        ]);

        $this->assertTrue($svc->delete($doc));
        $this->assertNull(Document::find($doc->id));
        $this->assertNotNull(Document::withTrashed()->find($doc->id)->deleted_at);
    }
}
