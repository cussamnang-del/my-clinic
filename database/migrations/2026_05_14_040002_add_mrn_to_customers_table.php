<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add a Medical Record Number (MRN) column to customers.
 *
 * ISO 15189:2022 §7.2.2 requires unique, unambiguous identification of
 * every patient/specimen. The legacy `customer_code` column was nullable
 * and never populated by the create flow (see audit-report.md → M-15).
 *
 * Strategy:
 *   - Add a NEW dedicated `mrn` column rather than reusing customer_code,
 *     so we don't break any legacy code that reads/writes customer_code.
 *   - mrn is nullable initially so the migration is non-destructive for
 *     existing rows; a follow-up backfill (php artisan customers:assign-mrn)
 *     is documented in CONTRIBUTING.md.
 *   - Unique + indexed so we can fast-look-up by MRN in the UI.
 *
 * Format (enforced by App\Services\MrnGenerator):
 *     LAB-YYYY-NNNNNN  e.g.  LAB-2026-000123
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('customers')) {
            return;
        }

        Schema::table('customers', function (Blueprint $table) {
            if (! Schema::hasColumn('customers', 'mrn')) {
                $table->string('mrn', 32)->nullable()->unique()->after('id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('customers') || ! Schema::hasColumn('customers', 'mrn')) {
            return;
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->dropUnique(['mrn']);
            $table->dropColumn('mrn');
        });
    }
};
