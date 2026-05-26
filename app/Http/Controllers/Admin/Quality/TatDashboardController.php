<?php

namespace App\Http\Controllers\Admin\Quality;

use App\Http\Controllers\Controller;
use App\Services\TatKpiService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Turn-Around Time (TAT) dashboard — KPI surface for the quality
 * manager. Displays:
 *
 *   - Window summary (today / 7d / 30d, switchable).
 *   - On-time %, mean/median/p90 TAT.
 *   - Per-day released-count + mean-TAT for the chart strip.
 *   - The most recent target-breached requests.
 *
 * ISO 15189:2022 §7.4.1 / §8.4.
 */
class TatDashboardController extends Controller
{
    protected string $prefix = 'quality_';

    public function __construct(private readonly TatKpiService $tat) {}

    public function index(Request $request): View
    {
        abort_if(Gate::denies($this->prefix.'access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Accept ?window=7d / 30d. Falls back to 7d.
        $window = $request->string('window', '7d')->toString();
        $days = match ($window) {
            '1d' => 0,
            '30d' => 29,
            default => 6,
        };

        $from = Carbon::now()->subDays($days)->startOfDay();
        $to = Carbon::now()->endOfDay();

        $summary = $this->tat->summary($from, $to);
        $breaches = $this->tat->breaches(20);

        return view('admin.quality.tat.index', [
            'prefix' => $this->prefix,
            'window' => $window,
            'summary' => $summary,
            'breaches' => $breaches,
        ]);
    }
}
