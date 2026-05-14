<?php

namespace Tests\Feature;

use App\Models\CapaAction;
use App\Models\NonConformance;
use App\Models\User;
use App\Services\CapaWorkflowService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CapaWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function makeNcrWithCapa(): array
    {
        $reporter = User::factory()->create();
        Auth::login($reporter);

        $ncr = NonConformance::create([
            'code' => 'NCR-2026-0001',
            'title' => 'QC out of range on chemistry analyser',
            'description' => 'Two consecutive QC runs > 3SD on Glucose level 2.',
            'source' => 'incident',
            'severity' => 'high',
            'reported_by' => $reporter->id,
        ]);

        $capa = CapaAction::create([
            'non_conformance_id' => $ncr->id,
            'action_type' => 'corrective',
            'action_plan' => 'Replace QC material and re-verify.',
            'assignee_id' => $reporter->id,
            'status' => CapaWorkflowService::STATE_OPEN,
        ]);

        return [$ncr, $capa, $reporter];
    }

    public function test_full_capa_lifecycle_closes_parent_ncr(): void
    {
        $svc = app(CapaWorkflowService::class);
        [$ncr, $capa, $reporter] = $this->makeNcrWithCapa();

        $capa = $svc->start($capa, $reporter);
        $capa->update(['action_taken' => 'Replaced QC lot.']);

        $capa = $svc->submitForEffectivenessCheck($capa->fresh(), $reporter);
        $capa->update(['verification_evidence' => '20 consecutive QC runs within ±2SD.']);

        $capa = $svc->close($capa->fresh(), $reporter);

        $this->assertSame(CapaWorkflowService::STATE_CLOSED, $capa->status);
        $this->assertSame('closed_with_capa', $ncr->fresh()->status);
        $this->assertNotNull($ncr->fresh()->closed_at);
    }

    public function test_cannot_submit_for_check_without_action_taken(): void
    {
        $svc = app(CapaWorkflowService::class);
        [, $capa, $user] = $this->makeNcrWithCapa();

        $capa = $svc->start($capa, $user);

        $this->expectException(DomainException::class);
        $svc->submitForEffectivenessCheck($capa, $user);
    }

    public function test_cannot_close_without_verification_evidence(): void
    {
        $svc = app(CapaWorkflowService::class);
        [, $capa, $user] = $this->makeNcrWithCapa();

        $capa = $svc->start($capa, $user);
        $capa->update(['action_taken' => 'Did the thing.']);
        $capa = $svc->submitForEffectivenessCheck($capa->fresh(), $user);

        $this->expectException(DomainException::class);
        $svc->close($capa, $user);
    }
}
