<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\CompetencyAssessment;
use App\Models\Equipment;
use App\Models\InternalAudit;
use App\Models\NonConformance;
use App\Models\QcResult;
use App\Models\ReagentLot;
use App\Models\Risk;
use App\Models\SopDocument;
use App\Models\TrainingRecord;
use App\Services\TatKpiService;
use Illuminate\View\View;

/**
 * Quality dashboard — top-level entry point for the Phase 3 ISO modules
 * + the Phase 5 reporting surfaces (TAT, QC, pending result release).
 *
 * Renders a card grid showing the current count + a "needs attention"
 * count per module so the quality manager can spot hot-spots at a
 * glance.
 */
class QualityDashboardController extends Controller
{
    public function __construct(private readonly TatKpiService $tat) {}

    public function index(): View
    {
        $today = now()->endOfDay();
        $weekAgo = now()->subDays(6)->startOfDay();

        $cards = [
            'sop' => [
                'label' => 'SOP Documents',
                'route' => 'admin.quality.sop.index',
                'total' => SopDocument::query()->count(),
                'attention' => SopDocument::query()->where('status', 'draft')->count(),
                'attention_label' => 'Draft',
                'icon' => 'bx bx-book-open',
            ],
            'equipment' => [
                'label' => 'Equipment',
                'route' => 'admin.quality.equipment.index',
                'total' => Equipment::query()->count(),
                'attention' => Equipment::query()
                    ->whereNotNull('next_calibration_due_at')
                    ->whereDate('next_calibration_due_at', '<=', now()->addDays(30))
                    ->count(),
                'attention_label' => 'Calibration due ≤30d',
                'icon' => 'bx bx-cog',
            ],
            'reagent' => [
                'label' => 'Reagent Lots',
                'route' => 'admin.quality.reagents.index',
                'total' => ReagentLot::query()->count(),
                'attention' => ReagentLot::query()
                    ->whereNotNull('expires_at')
                    ->whereDate('expires_at', '<=', now()->addDays(30))
                    ->count(),
                'attention_label' => 'Expiring ≤30d',
                'icon' => 'bx bx-flask',
            ],
            'ncr' => [
                'label' => 'Non-conformances',
                'route' => 'admin.quality.ncrs.index',
                'total' => NonConformance::query()->count(),
                'attention' => NonConformance::query()
                    ->whereIn('status', ['open', 'investigating'])
                    ->count(),
                'attention_label' => 'Open / investigating',
                'icon' => 'bx bx-error-circle',
            ],
            'risk' => [
                'label' => 'Risk Register',
                'route' => 'admin.quality.risks.index',
                'total' => Risk::query()->count(),
                'attention' => Risk::query()->where('inherent_score', '>=', 15)->count(),
                'attention_label' => 'Score ≥ 15',
                'icon' => 'bx bx-shield-quarter',
            ],
            'internal_audit' => [
                'label' => 'Internal Audits',
                'route' => 'admin.quality.internal_audits.index',
                'total' => InternalAudit::query()->count(),
                'attention' => InternalAudit::query()->where('status', 'planned')->count(),
                'attention_label' => 'Planned',
                'icon' => 'bx bx-search',
            ],
            'training' => [
                'label' => 'Training Records',
                'route' => 'admin.quality.training.index',
                'total' => TrainingRecord::query()->count(),
                'attention' => CompetencyAssessment::query()
                    ->whereNotNull('reassessment_due_at')
                    ->whereDate('reassessment_due_at', '<=', now()->addDays(30))
                    ->count(),
                'attention_label' => 'Reassessment due ≤30d',
                'icon' => 'bx bx-medal',
            ],
            'qc' => [
                'label' => 'QC Results',
                'route' => 'admin.quality.qc.index',
                'total' => QcResult::query()->count(),
                'attention' => QcResult::query()
                    ->whereIn('westgard_flag', ['1-3s', '2-2s', 'R-4s'])
                    ->where('measured_at', '>=', now()->subDays(30))
                    ->count(),
                'attention_label' => 'Out of control (30d)',
                'icon' => 'bx bx-bar-chart',
            ],
        ];

        $tatSummary = $this->tat->summary($weekAgo, $today);

        return view('admin.quality.dashboard', [
            'prefix' => 'quality_',
            'cards' => $cards,
            'tat' => $tatSummary,
        ]);
    }
}
