<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Models\QcResult;
use App\Services\QcStatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * QC results listing + Levey-Jennings chart.
 *
 * ISO 15189:2022 §7.3.7.2 ("Internal quality control"). The index
 * shows the most-recent runs, and a filtered "chart" view renders a
 * Levey-Jennings plot for a specific analyte/level/lot.
 */
class QcResultController extends Controller
{
    protected string $prefix = 'qc_result_';

    public function __construct(private readonly QcStatisticsService $stats) {}

    public function index(Request $request): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = QcResult::query()
            ->with(['equipment', 'operator'])
            ->orderByDesc('measured_at');

        if ($analyte = $request->string('analyte')->toString()) {
            $query->where('analyte', $analyte);
        }
        if ($level = $request->string('level')->toString()) {
            $query->where('level', $level);
        }
        if ($lot = $request->string('lot_number')->toString()) {
            $query->where('lot_number', $lot);
        }

        $results = $query->paginate(50)->appends($request->query());

        $analytes = QcResult::query()->distinct()->pluck('analyte')->sort()->values();
        $levels = QcResult::query()->distinct()->pluck('level')->sort()->values();

        return view('admin.quality.qc.index', [
            'prefix' => $this->prefix,
            'results' => $results,
            'analytes' => $analytes,
            'levels' => $levels,
            'filters' => [
                'analyte' => $analyte ?? null,
                'level' => $level ?? null,
                'lot_number' => $lot ?? null,
            ],
        ]);
    }

    public function chart(Request $request): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'analyte' => ['required', 'string', 'max:128'],
            'level' => ['required', 'string', 'max:32'],
            'lot_number' => ['nullable', 'string', 'max:64'],
            'limit' => ['nullable', 'integer', 'min:5', 'max:200'],
        ]);

        $chart = $this->stats->buildChartData(
            $data['analyte'],
            $data['level'],
            $data['lot_number'] ?? null,
            (int) ($data['limit'] ?? 30),
        );

        return view('admin.quality.qc.chart', [
            'prefix' => $this->prefix,
            'chart' => $chart,
            'analyte' => $data['analyte'],
            'level' => $data['level'],
            'lot' => $data['lot_number'] ?? null,
        ]);
    }
}
