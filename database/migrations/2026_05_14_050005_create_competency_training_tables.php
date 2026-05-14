<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Training & Competency records.
 *
 * ISO 15189:2022 §6.2.1 ("Personnel — competence requirements") and
 * §6.2.5 ("Continuing professional development and training") require
 * a per-staff register of competencies, with reassessment dates.
 *
 * Schema:
 *   competencies    — catalogue of skills the lab tracks.
 *   training_records — what training a user has completed.
 *   competency_assessments — periodic re-assessments by a supervisor.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('category', 64)->nullable();

            // Cadence for reassessment, in months. NULL = one-off.
            $table->unsignedSmallInteger('reassessment_interval_months')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('training_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('competency_id')->constrained('competencies')->cascadeOnDelete();
            $table->foreignId('trainer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('training_at');
            $table->string('training_type', 64)->nullable(); // onboarding / refresher / external / etc.

            $table->string('evidence_path', 512)->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'competency_id']);
        });

        Schema::create('competency_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('competency_id')->constrained('competencies')->cascadeOnDelete();
            $table->foreignId('assessor_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('assessed_at');

            // competent / conditional / not_yet_competent
            $table->string('result', 32);

            $table->text('notes')->nullable();

            // Pre-computed by App\Services\CompetencyAssessmentService at write
            // time from competencies.reassessment_interval_months.
            $table->date('reassessment_due_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'competency_id', 'assessed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competency_assessments');
        Schema::dropIfExists('training_records');
        Schema::dropIfExists('competencies');
    }
};
