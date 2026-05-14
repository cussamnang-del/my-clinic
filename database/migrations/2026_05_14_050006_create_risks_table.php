<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Risk register.
 *
 * ISO 9001:2015 §6.1 ("Actions to address risks and opportunities")
 * and ISO 15189:2022 §5.6 require a documented risk register with:
 *   - Likelihood × severity scoring.
 *   - Mitigation plan and residual risk.
 *   - Risk owner and review cadence.
 *
 * Inherent + residual scores are NOT stored as generated columns
 * (drivers differ between MySQL/PG/SQLite); instead they are computed
 * by App\Services\RiskScoringService and persisted on save.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('category', 64)->nullable();
            $table->text('description');

            // 1 (rare) ... 5 (almost certain) and 1 (negligible) ... 5 (catastrophic).
            $table->unsignedTinyInteger('likelihood');
            $table->unsignedTinyInteger('severity');
            $table->unsignedSmallInteger('score'); // likelihood × severity

            $table->text('mitigation')->nullable();

            $table->unsignedTinyInteger('residual_likelihood')->nullable();
            $table->unsignedTinyInteger('residual_severity')->nullable();
            $table->unsignedSmallInteger('residual_score')->nullable();

            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();

            // identified / mitigating / accepted / closed
            $table->string('status', 32)->default('identified');

            $table->date('next_review_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
