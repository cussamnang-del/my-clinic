<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Internal Audit + Audit Findings.
 *
 * ISO 9001:2015 §9.2 ("Internal audit") and ISO 15189:2022 §8.8
 * ("Internal audits") require:
 *   - A planned audit programme with scope and lead auditor.
 *   - Recorded findings (conformance, non-conformance, observation).
 *   - Linkage from non-conformance findings to an NCR/CAPA.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_audits', function (Blueprint $table) {
            $table->id();

            $table->string('code', 64)->unique();
            $table->string('scope', 255);

            $table->foreignId('lead_auditor_id')->nullable()->constrained('users')->nullOnDelete();

            // planned / in_progress / reporting / closed / cancelled
            $table->string('status', 32)->default('planned');

            $table->date('scheduled_at');
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();

            $table->text('summary')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('audit_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internal_audit_id')->constrained('internal_audits')->cascadeOnDelete();

            // conformance / non_conformance / observation / opportunity
            $table->string('finding_type', 32);
            // minor / major / critical / informational
            $table->string('severity', 16)->nullable();

            $table->text('description');
            $table->string('clause_reference', 128)->nullable();

            // If the finding produced an NCR, link to it.
            $table->foreignId('non_conformance_id')->nullable()
                ->constrained('non_conformances')->nullOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_findings');
        Schema::dropIfExists('internal_audits');
    }
};
