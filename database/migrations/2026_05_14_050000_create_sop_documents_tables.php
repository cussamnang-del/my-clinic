<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Document Control: Standard Operating Procedures (SOPs).
 *
 * ISO 9001:2015 §7.5 ("Documented information") requires every
 * controlled document to have:
 *   - A unique identifier and a title.
 *   - A revision history with approver and effective date.
 *   - A retirement / supersession mechanism.
 *   - Evidence that affected staff have read the current version.
 *
 * Schema:
 *
 *   sop_documents          — the document itself (one row per SOP).
 *   sop_revisions          — every version of every SOP, append-only.
 *   sop_acknowledgements   — staff read-receipts (one per user × revision).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sop_documents', function (Blueprint $table) {
            $table->id();

            // Stable user-facing reference (e.g. "SOP-LAB-001").
            $table->string('code', 64)->unique();
            $table->string('title', 255);
            $table->string('category', 64)->nullable();

            // The user who is on the hook for keeping this SOP current.
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Points at the latest *active* revision once the SOP has one.
            // Nullable because a brand-new SOP exists before its first
            // revision is approved.
            $table->foreignId('current_revision_id')->nullable();

            // active / superseded / retired
            $table->string('status', 32)->default('draft');

            $table->timestamp('effective_at')->nullable();
            $table->timestamp('retired_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sop_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sop_document_id')->constrained('sop_documents')->cascadeOnDelete();

            // Monotonic per sop_document_id; uniqueness enforced by the
            // composite index below.
            $table->unsignedSmallInteger('revision_number');

            // Either an inline summary or a path to the controlled PDF / DOCX
            // (per ISO 9001:2015 §7.5.3 we just need a controlled, traceable
            // pointer; the binary itself lives on the storage disk).
            $table->string('content_path', 512)->nullable();
            $table->text('change_summary');

            // Workflow: draft → submitted → approved → effective → superseded
            $table->string('status', 32)->default('draft');

            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->timestamp('effective_at')->nullable();
            $table->timestamp('superseded_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['sop_document_id', 'revision_number'], 'sop_revisions_doc_rev_unique');
        });

        // sop_documents.current_revision_id → sop_revisions(id).
        // Added after sop_revisions exists to avoid a chicken-and-egg FK.
        Schema::table('sop_documents', function (Blueprint $table) {
            $table->foreign('current_revision_id', 'sop_documents_current_revision_fk')
                ->references('id')->on('sop_revisions')->nullOnDelete();
        });

        Schema::create('sop_acknowledgements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sop_revision_id')->constrained('sop_revisions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('acknowledged_at')->useCurrent();

            // Capture provenance for the read-receipt.
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 512)->nullable();

            $table->timestamps();

            // A user can only acknowledge a given revision once.
            $table->unique(['sop_revision_id', 'user_id'], 'sop_acks_revision_user_unique');
        });
    }

    public function down(): void
    {
        Schema::table('sop_documents', function (Blueprint $table) {
            try {
                $table->dropForeign('sop_documents_current_revision_fk');
            } catch (Throwable) {
                // SQLite or already dropped — fine.
            }
        });

        Schema::dropIfExists('sop_acknowledgements');
        Schema::dropIfExists('sop_revisions');
        Schema::dropIfExists('sop_documents');
    }
};
