<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-analyte reference ranges, optionally segmented by sex and age.
 *
 * ISO 15189:2022 §7.3.7.2 ("Biological reference intervals and clinical
 * decision values") requires that every reportable result have a
 * documented reference range and, where clinically relevant, a critical
 * value threshold that triggers an alert.
 *
 * Lookup precedence (App\Services\ReferenceRangeLookup):
 *   1. Most specific (sex + age band) wins.
 *   2. Falls back to "any sex" within the matching age band.
 *   3. Finally falls back to the catch-all (sex=null AND age_min_days=null).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_ranges', function (Blueprint $table) {
            $table->id();

            // The analyte / test item this range applies to.
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();

            // 'M', 'F', or NULL (any).
            $table->string('sex', 1)->nullable();

            // Inclusive age band in DAYS. NULL on either end = open-ended.
            $table->unsignedInteger('age_min_days')->nullable();
            $table->unsignedInteger('age_max_days')->nullable();

            // Normal range.
            $table->decimal('low_value', 12, 4)->nullable();
            $table->decimal('high_value', 12, 4)->nullable();

            // Critical thresholds — values strictly outside this range
            // should trigger a `critical` flag on the result.
            $table->decimal('critical_low', 12, 4)->nullable();
            $table->decimal('critical_high', 12, 4)->nullable();

            // Reporting unit, e.g. "g/dL", "mmol/L".
            $table->string('unit', 32)->nullable();

            // Provenance: where this range came from (lab manual, CLSI doc, etc).
            $table->string('source', 255)->nullable();

            // ISO 9001 §7.5.3 — every reference range is itself a controlled
            // document; track who set it and when.
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Most queries: "find a range for item X". Add a composite
            // covering index for the common lookup shape.
            $table->index(['item_id', 'sex', 'age_min_days', 'age_max_days']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_ranges');
    }
};
