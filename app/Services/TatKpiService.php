<?php

namespace App\Services;

use App\Models\BioDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Turn-Around-Time (TAT) KPI service for lab results.
 *
 * ISO 15189:2022 §7.4.1 ("Reporting of results") and §8.4 require the
 * lab to define a TAT target per test and to monitor performance
 * against that target. This service exposes the metrics needed to:
 *   - Show a TAT dashboard (today / last 7 days / last 30 days).
 *   - Flag breached requests for follow-up.
 *   - Feed a histogram / line chart for QMS review meetings.
 *
 * TAT is measured from `submitted_at` (sample logged into the lab
 * workflow) to `released_at` (result released to the clinician).
 * Released-but-amended results are tracked as part of the same
 * release event since the amendment is a correction, not a new
 * cycle.
 */
class TatKpiService
{
    /** Default lab-wide TAT target — used when the test row doesn't
     *  override it. Configurable via config('observability.tat_target_minutes'). */
    public function targetMinutes(): int
    {
        return (int) config('observability.tat_target_minutes', 240);
    }

    /**
     * Build a TAT summary for the given window.
     *
     * @return array{
     *   from: string,
     *   to: string,
     *   target_minutes: int,
     *   total: int,
     *   released: int,
     *   pending: int,
     *   breached: int,
     *   on_time_pct: float,
     *   avg_minutes: float|null,
     *   median_minutes: float|null,
     *   p90_minutes: float|null,
     *   per_day: array<int, array{day: string, released: int, avg_minutes: float|null}>
     * }
     */
    public function summary(Carbon $from, Carbon $to): array
    {
        $target = $this->targetMinutes();

        $rows = BioDetail::query()
            ->whereNotNull('submitted_at')
            ->where('submitted_at', '>=', $from)
            ->where('submitted_at', '<=', $to)
            ->get(['id', 'submitted_at', 'released_at', 'result_status']);

        $total = $rows->count();
        $releasedRows = $rows->filter(fn (BioDetail $r) => $r->released_at !== null);
        $released = $releasedRows->count();
        $pending = $total - $released;

        $minutes = $releasedRows
            ->map(fn (BioDetail $r) => (float) $r->submitted_at->diffInMinutes($r->released_at, true))
            ->values();

        $breached = $minutes->filter(fn ($m) => $m > $target)->count();

        $onTimePct = $released === 0
            ? 0.0
            : round((($released - $breached) / $released) * 100, 1);

        return [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'target_minutes' => $target,
            'total' => $total,
            'released' => $released,
            'pending' => $pending,
            'breached' => $breached,
            'on_time_pct' => $onTimePct,
            'avg_minutes' => $this->mean($minutes),
            'median_minutes' => $this->percentile($minutes, 50),
            'p90_minutes' => $this->percentile($minutes, 90),
            'per_day' => $this->perDay($releasedRows, $from, $to),
        ];
    }

    /**
     * Group released rows by day-of-release and compute per-day
     * count + mean. Always returns one entry per day in the window
     * so the chart shows zero-days too.
     *
     * @param  Collection<int, BioDetail>  $releasedRows
     * @return array<int, array{day: string, released: int, avg_minutes: float|null}>
     */
    protected function perDay(Collection $releasedRows, Carbon $from, Carbon $to): array
    {
        $byDay = $releasedRows->groupBy(fn (BioDetail $r) => $r->released_at->toDateString());

        $cursor = $from->copy()->startOfDay();
        $end = $to->copy()->startOfDay();
        $out = [];

        while ($cursor->lte($end)) {
            $day = $cursor->toDateString();
            $rows = $byDay->get($day, collect());
            $minutes = $rows->map(fn (BioDetail $r) => (float) $r->submitted_at->diffInMinutes($r->released_at, true));
            $out[] = [
                'day' => $day,
                'released' => $rows->count(),
                'avg_minutes' => $this->mean($minutes),
            ];
            $cursor->addDay();
        }

        return $out;
    }

    /**
     * Returns recently-breached results so the dashboard can list
     * them for follow-up. Includes both pending breaches (still
     * unreleased past target) and released breaches.
     *
     * @return Collection<int, BioDetail>
     */
    public function breaches(int $limit = 20): Collection
    {
        $target = $this->targetMinutes();
        $cutoff = now()->subMinutes($target);

        return BioDetail::query()
            ->whereNotNull('submitted_at')
            ->where(function ($q) use ($cutoff) {
                $q->where(function ($qq) use ($cutoff) {
                    // Pending and already past target.
                    $qq->whereNull('released_at')->where('submitted_at', '<', $cutoff);
                })->orWhere(function ($qq) {
                    // Released slow (calculated client-side; pull all
                    // released rows from the last 30 days then filter).
                    $qq->whereNotNull('released_at')
                        ->where('released_at', '>=', now()->subDays(30));
                });
            })
            ->orderByDesc('submitted_at')
            ->limit($limit * 4)
            ->get()
            ->filter(function (BioDetail $r) use ($target) {
                if ($r->released_at === null) {
                    return true; // already filtered by the cutoff above
                }

                return $r->submitted_at->diffInMinutes($r->released_at, true) > $target;
            })
            ->take($limit)
            ->values();
    }

    protected function mean(Collection $values): ?float
    {
        if ($values->isEmpty()) {
            return null;
        }

        return round($values->sum() / $values->count(), 1);
    }

    protected function percentile(Collection $values, int $p): ?float
    {
        if ($values->isEmpty()) {
            return null;
        }

        $sorted = $values->sort()->values();
        $n = $sorted->count();
        $rank = ($p / 100) * ($n - 1);
        $low = (int) floor($rank);
        $high = (int) ceil($rank);

        if ($low === $high) {
            return round((float) $sorted[$low], 1);
        }

        $weight = $rank - $low;

        return round(((float) $sorted[$low]) * (1 - $weight) + ((float) $sorted[$high]) * $weight, 1);
    }
}
