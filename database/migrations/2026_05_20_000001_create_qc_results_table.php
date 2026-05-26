<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Quality-control results table — the data source for Levey-Jennings
 * charts and Westgard-rule evaluation.
 *
 * ISO 15189:2022 §7.3.7.2 ("Internal quality control") requires labs
 * to plot QC values against the established mean / SD and react when
 * Westgard rules flag a run as out-of-control. This table stores one
 * row per control measurement so the chart can be reconstructed.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qc_results', function (Blueprint $table) {
            $table->id();

            // Which analyte (e.g. "Glucose", "Hemoglobin"). Free-form so
            // the lab can introduce new tests without a schema change.
            $table->string('analyte', 128);

            // Control material identifier (e.g. "BioRad L1", "Internal QC").
            $table->string('control_name', 128);

            // QC level — usually "low", "normal", "high".
            $table->string('level', 32);

            // Lot identifier so a level switch (which invalidates the
            // statistics) is auditable.
            $table->string('lot_number', 64)->nullable();

            // Optional FK to the instrument / equipment that produced
            // the reading.
            $table->foreignId('equipment_id')->nullable()->constrained('equipment')->nullOnDelete();

            // Measurement value + reporting unit.
            $table->decimal('value', 12, 4);
            $table->string('unit', 32)->nullable();

            // Established statistics for this lot. Stored on each row
            // so historical Westgard evaluations stay reproducible even
            // if the lab updates the mean/SD later.
            $table->decimal('mean', 12, 4)->nullable();
            $table->decimal('sd', 12, 4)->nullable();

            // When the QC was actually measured (not insert time).
            $table->dateTime('measured_at');

            // Operator / analyst.
            $table->foreignId('operator_id')->nullable()->constrained('users')->nullOnDelete();

            // accepted / rejected / pending_review — set by the lab
            // supervisor after reviewing the Westgard evaluation.
            $table->string('status', 32)->default('accepted');

            // Cached Westgard flag set on insert (e.g. "1-3s", "2-2s").
            // Empty string when the result is in control.
            $table->string('westgard_flag', 16)->nullable();

            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Most queries fetch "last N runs for this analyte+level+lot".
            $table->index(['analyte', 'level', 'lot_number', 'measured_at'], 'qc_results_lookup_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qc_results');
    }
};
