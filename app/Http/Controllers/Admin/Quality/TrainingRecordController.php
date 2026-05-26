<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\CompetencyAssessment;
use App\Models\TrainingRecord;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read-only listing for Training & Competency records.
 *
 * ISO 15189:2022 §6.2.5. Side-by-side view of training events and
 * the linked competency assessments + reassessment due dates so a
 * supervisor can spot lapsed competencies.
 */
class TrainingRecordController extends Controller
{
    protected string $prefix = 'competency_';

    public function index(): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $training = TrainingRecord::query()
            ->with(['user', 'competency', 'trainer'])
            ->orderByDesc('training_at')
            ->paginate(25);

        $assessments = CompetencyAssessment::query()
            ->with(['user', 'competency', 'assessor'])
            ->orderByDesc('assessed_at')
            ->limit(50)
            ->get();

        return view('admin.quality.training.index', [
            'prefix' => $this->prefix,
            'training' => $training,
            'assessments' => $assessments,
            'dueCutoff' => now()->addDays(30)->toDateString(),
        ]);
    }
}
