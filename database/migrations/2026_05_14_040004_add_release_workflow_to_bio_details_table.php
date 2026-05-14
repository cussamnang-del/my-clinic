<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add an immutable Sample → Result release workflow to bio_details
 * (the actual reportable lab results in this schema).
 *
 * State machine (enforced by App\Services\ResultReleaseService):
 *
 *   draft                                  ← row freshly created
 *     │ submit()  reqs: result_status=draft
 *     ▼
 *   submitted_for_review
 *     │ review() reqs: status=submitted, reviewer ≠ submitter
 *     ▼
 *   reviewed
 *     │ release() reqs: status=reviewed,  releaser ≠ submitter
 *     ▼
 *   released                               ← reportable, immutable
 *     │ amend()  reqs: status=released,  reason non-empty
 *     ▼
 *   amended                                ← amendment chain head
 *
 * Backwards compatibility:
 *   - Pre-existing bio_details rows are stamped `released` so the
 *     existing UI flow does not break. They have no submitter/reviewer
 *     metadata — that's accepted as legacy data per ISO 9001 §7.5.3
 *     "records of external origin".
 *   - The `result_flag` column is computed on save by
 *     App\Services\ReferenceRangeLookup ("normal" / "low" / "high" /
 *     "critical_low" / "critical_high") — nullable for results that
 *     have no matching reference range.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bio_details')) {
            return;
        }

        Schema::table('bio_details', function (Blueprint $table) {
            if (! Schema::hasColumn('bio_details', 'result_status')) {
                $table->string('result_status', 32)->default('released')->after('note');
                $table->index('result_status');
            }
            if (! Schema::hasColumn('bio_details', 'result_flag')) {
                $table->string('result_flag', 16)->nullable()->after('result_status');
            }

            foreach (['submitted', 'reviewed', 'released', 'amended'] as $event) {
                $userCol = $event.'_by';
                $atCol = $event.'_at';

                if (! Schema::hasColumn('bio_details', $userCol)) {
                    $table->foreignId($userCol)->nullable()->after('result_flag')
                        ->constrained('users')->nullOnDelete();
                }
                if (! Schema::hasColumn('bio_details', $atCol)) {
                    $table->timestamp($atCol)->nullable()->after($userCol);
                }
            }

            if (! Schema::hasColumn('bio_details', 'amendment_reason')) {
                $table->string('amendment_reason', 512)->nullable()->after('amended_at');
            }
            if (! Schema::hasColumn('bio_details', 'amends_id')) {
                $table->foreignId('amends_id')->nullable()->after('amendment_reason')
                    ->references('id')->on('bio_details')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('bio_details')) {
            return;
        }

        Schema::table('bio_details', function (Blueprint $table) {
            $cols = [
                'amends_id',
                'amendment_reason',
                'amended_at', 'amended_by',
                'released_at', 'released_by',
                'reviewed_at', 'reviewed_by',
                'submitted_at', 'submitted_by',
                'result_flag', 'result_status',
            ];

            foreach ($cols as $col) {
                if (Schema::hasColumn('bio_details', $col)) {
                    if (str_ends_with($col, '_by') || $col === 'amends_id') {
                        try {
                            $table->dropConstrainedForeignId($col);
                        } catch (Throwable) {
                            $table->dropColumn($col);
                        }
                    } else {
                        $table->dropColumn($col);
                    }
                }
            }
        });
    }
};
