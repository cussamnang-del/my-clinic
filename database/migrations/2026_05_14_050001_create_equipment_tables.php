<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Equipment & Calibration register.
 *
 * ISO 15189:2022 §6.4 ("Equipment") and §6.5 ("Equipment calibration
 * and metrological traceability") require:
 *   - An identifiable asset register.
 *   - Calibration records with date, due-date, and result.
 *   - Out-of-service tracking when calibration fails.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Stable asset tag (e.g. "EQ-CBC-001"). UNIQUE so the UI can
            // resolve barcode scans to a single asset.
            $table->string('code', 64)->unique();
            $table->string('name', 255);
            $table->string('manufacturer', 128)->nullable();
            $table->string('model', 128)->nullable();
            $table->string('serial_no', 128)->nullable();
            $table->string('location', 128)->nullable();

            // active / inactive / out_of_service / retired
            $table->string('status', 32)->default('active');

            $table->date('commissioned_at')->nullable();
            $table->date('retired_at')->nullable();

            // Cached pointer to the latest calibration row so the UI can
            // colour-code "due for calibration" in O(1).
            $table->date('last_calibrated_at')->nullable();
            $table->date('next_calibration_due_at')->nullable();

            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('equipment_calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();

            $table->date('calibration_date');
            $table->date('due_date');

            // pass / conditional / fail
            $table->string('result', 32);

            // The external provider / engineer responsible. Free text since
            // many sites use third-party calibration houses that don't have
            // user accounts in this system.
            $table->string('performed_by_external', 255)->nullable();

            $table->string('certificate_path', 512)->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['equipment_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_calibrations');
        Schema::dropIfExists('equipment');
    }
};
