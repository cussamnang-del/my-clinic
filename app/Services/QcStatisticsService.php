<?php

namespace App\Services;

use App\Models\QcResult;
use Illuminate\Support\Collection;

/**
 * Computes Levey-Jennings chart data and evaluates Westgard rules
 * against a series of QC measurements.
 *
 * Westgard rules implemented (the four most commonly used for
 * single-rule + multi-rule QC review per ISO 15189:2022 §7.3.7.2):
 *
 *   1-3s  — one value exceeds the mean ± 3 SD                  (reject)
 *   2-2s  — two consecutive values exceed the mean ± 2 SD on
 *           the same side                                       (reject)
 *   R-4s  — the range between two consecutive values exceeds 4 SD
 *                                                                (reject)
 *   1-2s  — one value exceeds the mean ± 2 SD                  (warning)
 *
 * The service returns a plain array of points so the Blade chart can
 * be backed by either Chart.js (preferred when JS is available) or
 * a server-rendered SVG fallback.
 */
class QcStatisticsService
{
    public const FLAG_1_3S = '1-3s';

    public const FLAG_2_2S = '2-2s';

    public const FLAG_R_4S = 'R-4s';

    public const FLAG_1_2S = '1-2s';

    /**
     * Build a Levey-Jennings dataset for a given analyte/level/lot.
     *
     * @return array{
     *   points: array<int, array{measured_at: string, value: float, z: float|null, flag: string|null}>,
     *   mean: float|null,
     *   sd: float|null,
     *   in_control: bool,
     *   summary: array{accepted: int, rejected: int, pending_review: int, total: int}
     * }
     */
    public function buildChartData(string $analyte, string $level, ?string $lotNumber = null, int $limit = 30): array
    {
        $query = QcResult::query()
            ->where('analyte', $analyte)
            ->where('level', $level)
            ->orderBy('measured_at');

        if ($lotNumber !== null && $lotNumber !== '') {
            $query->where('lot_number', $lotNumber);
        }

        $rows = $query->limit($limit)->get();

        $mean = $rows->first()?->mean !== null ? (float) $rows->first()->mean : null;
        $sd = $rows->first()?->sd !== null ? (float) $rows->first()->sd : null;

        $points = [];
        $previousValue = null;
        $previousZ = null;

        foreach ($rows as $row) {
            $value = (float) $row->value;
            $z = ($sd !== null && $sd > 0 && $mean !== null) ? ($value - $mean) / $sd : null;

            $flag = $this->classify($value, $previousValue, $z, $previousZ, $mean, $sd);

            $points[] = [
                'measured_at' => $row->measured_at?->toIso8601String(),
                'value' => $value,
                'z' => $z,
                'flag' => $flag,
                'status' => (string) $row->status,
            ];

            $previousValue = $value;
            $previousZ = $z;
        }

        $summary = [
            'accepted' => $rows->where('status', 'accepted')->count(),
            'rejected' => $rows->where('status', 'rejected')->count(),
            'pending_review' => $rows->where('status', 'pending_review')->count(),
            'total' => $rows->count(),
        ];

        $inControl = ! collect($points)->contains(fn ($p) => in_array($p['flag'], [self::FLAG_1_3S, self::FLAG_2_2S, self::FLAG_R_4S], true));

        return [
            'points' => $points,
            'mean' => $mean,
            'sd' => $sd,
            'in_control' => $inControl,
            'summary' => $summary,
        ];
    }

    /**
     * Evaluate a single value against the mean / SD and the previous
     * point. Returns the highest-severity Westgard flag triggered, or
     * null when the value is in control.
     *
     * Order matters: reject rules win over warning rules.
     */
    public function classify(float $value, ?float $previousValue, ?float $z, ?float $previousZ, ?float $mean, ?float $sd): ?string
    {
        if ($z === null) {
            return null;
        }

        if (abs($z) >= 3.0) {
            return self::FLAG_1_3S;
        }

        if ($previousZ !== null) {
            // 2-2s — two consecutive on the same side beyond ±2 SD
            if (abs($z) >= 2.0 && abs($previousZ) >= 2.0 && ($z * $previousZ) > 0) {
                return self::FLAG_2_2S;
            }

            // R-4s — range exceeds 4 SD between two consecutive runs
            if (abs($z - $previousZ) >= 4.0) {
                return self::FLAG_R_4S;
            }
        }

        if (abs($z) >= 2.0) {
            return self::FLAG_1_2S;
        }

        return null;
    }

    /**
     * Compute mean/SD from a Collection of values. Useful when the lab
     * wants to re-baseline statistics after a new lot is brought
     * online. Returns null mean/SD when n < 2.
     *
     * @param  Collection<int, float|int|string>  $values
     * @return array{mean: float|null, sd: float|null, n: int}
     */
    public function baseline(Collection $values): array
    {
        $n = $values->count();

        if ($n < 2) {
            return ['mean' => null, 'sd' => null, 'n' => $n];
        }

        $nums = $values->map(fn ($v) => (float) $v)->all();
        $mean = array_sum($nums) / $n;

        $variance = 0.0;
        foreach ($nums as $v) {
            $variance += ($v - $mean) ** 2;
        }
        // Sample standard deviation (n-1) — matches Westgard convention.
        $sd = sqrt($variance / ($n - 1));

        return ['mean' => $mean, 'sd' => $sd, 'n' => $n];
    }
}
