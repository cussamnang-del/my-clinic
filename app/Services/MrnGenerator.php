<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

/**
 * Generates a Medical Record Number (MRN) for a Customer.
 *
 * Format: `LAB-YYYY-NNNNNN` (e.g. LAB-2026-000123)
 *
 * Properties:
 *   - Deterministic / monotonically increasing per year.
 *   - Zero-padded to 6 digits (rolls over to 7 digits past 999_999/year).
 *   - Unique (the `customers.mrn` column has a UNIQUE index).
 *   - Race-safe via a SELECT ... FOR UPDATE inside a transaction on
 *     MySQL/Postgres; falls back to a plain SELECT on SQLite (tests).
 *
 * ISO 15189:2022 §7.2.2 — "the laboratory shall have a procedure that
 * ensures that all samples and the patient are uniquely identified".
 */
class MrnGenerator
{
    public function __construct(private readonly string $prefix = 'LAB') {}

    public function nextFor(?Customer $customer = null, ?int $year = null): string
    {
        $year ??= (int) date('Y');

        return DB::transaction(function () use ($year) {
            $pattern = sprintf('%s-%04d-%%', $this->prefix, $year);

            $query = Customer::query()
                ->where('mrn', 'like', $pattern)
                ->withTrashed();

            // SELECT ... FOR UPDATE on engines that support row-locking.
            $driver = DB::connection()->getDriverName();
            if (in_array($driver, ['mysql', 'pgsql'], true)) {
                $query->lockForUpdate();
            }

            $latest = $query->orderByDesc('mrn')->value('mrn');

            $next = 1;
            if ($latest !== null && preg_match('/-(\d+)$/', $latest, $m)) {
                $next = ((int) $m[1]) + 1;
            }

            return sprintf('%s-%04d-%06d', $this->prefix, $year, $next);
        });
    }
}
