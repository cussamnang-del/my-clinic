<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Smoke-test the Phase 5 quality routes — verifies routes are wired,
 * permissions resolve, and the view layer renders without errors.
 *
 * Permission gates are bypassed in tests by attaching the Super Admin
 * role (matches the Gate::before bypass in AuthServiceProvider).
 */
class QualityDashboardRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        DB::statement('PRAGMA foreign_keys = OFF');

        // Disable 2FA enforcement for these smoke tests; the
        // EnsureTwoFactorVerifiedTest suite already covers the 2FA
        // redirect behaviour.
        config()->set('security.two_factor.enforced', false);
    }

    private function actingAsSuperAdmin(): User
    {
        $user = User::factory()->create();
        $role = Role::create(['title' => 'Super Admin']);
        $user->roles()->attach($role->id);
        $this->actingAs($user);

        return $user;
    }

    public function test_quality_dashboard_renders(): void
    {
        $this->actingAsSuperAdmin();

        $response = $this->get(route('admin.quality.dashboard'));

        $response->assertOk();
        $response->assertSee('SOP Documents');
        $response->assertSee('Turn-Around Time');
    }

    public function test_quality_sop_listing_renders(): void
    {
        $this->actingAsSuperAdmin();

        $response = $this->get(route('admin.quality.sop.index'));

        $response->assertOk();
        $response->assertSee('SOP / Document Control');
    }

    public function test_quality_tat_dashboard_renders_for_empty_dataset(): void
    {
        $this->actingAsSuperAdmin();

        $response = $this->get(route('admin.quality.tat.index'));

        $response->assertOk();
        $response->assertSee('On-time %');
    }

    public function test_quality_qc_listing_renders(): void
    {
        $this->actingAsSuperAdmin();

        $response = $this->get(route('admin.quality.qc.index'));

        $response->assertOk();
    }

    public function test_quality_results_worklist_renders(): void
    {
        $this->actingAsSuperAdmin();

        $response = $this->get(route('admin.quality.results.index'));

        $response->assertOk();
        $response->assertSee('Result Release Worklist');
    }
}
