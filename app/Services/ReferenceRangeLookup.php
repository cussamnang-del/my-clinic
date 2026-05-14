<?php

namespace App\Services;

use App\Models\ReferenceRange;
use Carbon\CarbonInterface;

/**
 * Resolves the most-specific reference range for a given (analyte,
 * patient demographics) tuple, and flags a numeric result against it.
 *
 * Specificity ordering (most → least):
 *   1. sex match (M or F) AND patient age within [age_min_days,age_max_days]
 *   2. sex match, no age band
 *   3. age band match, no sex
 *   4. catch-all (no sex, no age band)
 *
 * Returns null if no range matches — the caller is expected to record
 * the result with result_flag = null in that case.
 */
class ReferenceRangeLookup
{
    public function findFor(int $itemId, ?string $sex, ?CarbonInterface $dob): ?ReferenceRange
    {
        $ageDays = $dob ? $dob->diffInDays(now()) : null;

        return ReferenceRange::query()
            ->where('item_id', $itemId)
            ->where(function ($q) use ($sex) {
                $q->whereNull('sex');
                if ($sex !== null) {
                    $q->orWhere('sex', strtoupper($sex));
                }
            })
            ->where(function ($q) use ($ageDays) {
                $q->where(function ($q) {
                    $q->whereNull('age_min_days')->whereNull('age_max_days');
                });
                if ($ageDays !== null) {
                    $q->orWhere(function ($q) use ($ageDays) {
                        $q->where(function ($q) use ($ageDays) {
                            $q->whereNull('age_min_days')->orWhere('age_min_days', '<=', $ageDays);
                        })->where(function ($q) use ($ageDays) {
                            $q->whereNull('age_max_days')->orWhere('age_max_days', '>=', $ageDays);
                        });
                    });
                }
            })
            ->orderByRaw('CASE WHEN sex IS NULL THEN 1 ELSE 0 END')
            ->orderByRaw('CASE WHEN age_min_days IS NULL AND age_max_days IS NULL THEN 1 ELSE 0 END')
            ->first();
    }

    /**
     * Classify a numeric result against a reference range.
     *
     * Returns one of:
     *   - 'critical_low'  — value < critical_low
     *   - 'low'           — critical_low <= value < low_value
     *   - 'normal'        — low_value <= value <= high_value
     *   - 'high'          — high_value < value <= critical_high
     *   - 'critical_high' — value > critical_high
     *   - null            — value couldn't be parsed as a number, or the
     *                       range has no usable bounds.
     */
    public function flagValue(?ReferenceRange $range, float|int|string|null $value): ?string
    {
        if ($range === null || $value === null || ! is_numeric($value)) {
            return null;
        }

        $value = (float) $value;

        if ($range->critical_low !== null && $value < (float) $range->critical_low) {
            return 'critical_low';
        }
        if ($range->critical_high !== null && $value > (float) $range->critical_high) {
            return 'critical_high';
        }
        if ($range->low_value !== null && $value < (float) $range->low_value) {
            return 'low';
        }
        if ($range->high_value !== null && $value > (float) $range->high_value) {
            return 'high';
        }
        if ($range->low_value !== null || $range->high_value !== null) {
            return 'normal';
        }

        return null;
    }
}
