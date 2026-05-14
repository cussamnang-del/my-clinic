<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Append-only audit trail of every change made to a "loggable" model
 * (anything using App\Concerns\IsLoggable).
 *
 * Required by ISO 9001:2015 §7.5.3 "Control of documented information"
 * and ISO 15189:2022 §8.4 "Control of records". Each row captures who
 * did what, when, from where, and what the field-level diff was.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // What kind of event: 'created', 'updated', 'deleted', 'restored',
            // 'result.submitted', 'result.reviewed', 'result.released',
            // 'result.amended', or any custom event name passed to
            // ActivityLogService::record().
            $table->string('event', 64)->index();

            // The model that was changed (polymorphic).
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->index(['subject_type', 'subject_id']);

            // The user who performed the change. Nullable because system /
            // queue / console actions are valid causers too.
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('causer_type')->nullable();

            // JSON diff: { "old": {...}, "new": {...} } — both bags are
            // already redacted of password / two_factor_secret etc by
            // ActivityLogService.
            $table->json('properties')->nullable();

            // Optional free-text reason — required for result amendments,
            // optional elsewhere.
            $table->string('reason', 512)->nullable();

            // Provenance.
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 512)->nullable();

            $table->timestamp('logged_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
