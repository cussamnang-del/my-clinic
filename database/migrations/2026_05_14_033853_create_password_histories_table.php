<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Track every password a user has ever set so we can prevent reuse of
 * the last N passwords (default: 5, configurable via
 * config('security.password_history.depth')).
 *
 * Maps to:
 *   - docs/audit-report.md → H-9 "No password-reuse prevention"
 *   - ISO 27001:2022 Annex A 5.17
 *   - NIST SP 800-63B §5.1.1.2 (Memorized Secret Verifiers — do not allow
 *     reuse of recently-used secrets)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            // bcrypt hashes are up to 60 chars; allow 255 for future
            // algorithms (argon2id is ~96 chars including the prefix).
            $table->string('password_hash', 255);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_histories');
    }
};
