<?php

namespace Tests\Feature;

use App\Models\AuditFinding;
use App\Models\InternalAudit;
use App\Models\NonConformance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class InternalAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_finding_can_link_to_a_non_conformance(): void
    {
        $auditor = User::factory()->create();
        Auth::login($auditor);

        $audit = InternalAudit::create([
            'code' => 'IA-2026-001',
            'scope' => 'Pre-analytical sample handling',
            'lead_auditor_id' => $auditor->id,
            'scheduled_at' => '2026-02-01',
        ]);

        $ncr = NonConformance::create([
            'code' => 'NCR-2026-0099',
            'title' => 'Mislabeled specimens found',
            'description' => 'Three specimens lacked barcoded labels.',
            'source' => 'internal_audit',
            'severity' => 'medium',
            'reported_by' => $auditor->id,
        ]);

        $finding = AuditFinding::create([
            'internal_audit_id' => $audit->id,
            'finding_type' => 'non_conformance',
            'severity' => 'major',
            'description' => 'Specimen labels missing.',
            'non_conformance_id' => $ncr->id,
        ]);

        $this->assertSame($audit->id, $finding->internalAudit->id);
        $this->assertSame($ncr->id, $finding->nonConformance->id);
        $this->assertCount(1, $audit->fresh()->findings);
    }
}
