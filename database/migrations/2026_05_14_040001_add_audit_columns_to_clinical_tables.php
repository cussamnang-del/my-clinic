<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add the Blameable + SoftDeletes columns to every clinical table.
 *
 * ISO 9001:2015 §7.5.3 (control of documented information) and
 * ISO 15189:2022 §8.4 (control of records) require that every change
 * to a clinical record be attributable to a named individual and that
 * deletions be reversible during the retention period.
 *
 * Adds:
 *   - created_by   (nullable FK users)
 *   - updated_by   (nullable FK users)
 *   - deleted_by   (nullable FK users)
 *   - deleted_at   (Eloquent SoftDeletes)
 *
 * Foreign keys are nullable + nullOnDelete so deleting a user account
 * never cascades into clinical records (we keep the historical record
 * with a NULL causer instead).
 */
return new class extends Migration
{
    /**
     * Tables that get the full Blameable + SoftDeletes treatment.
     * Master / lookup tables (provinces, items, products, settings…)
     * intentionally don't get SoftDeletes — they're not clinical records.
     */
    private array $clinicalTables = [
        'customers',
        'documents',
        'document_details',
        'document_lives',
        'document_life_details',
        'bios',
        'bio_details',
        'pbios',
        'pbio_details',
        'rxes',
        'rx_details',
        'rx_docfiles',
        'hospital_treatments',
        'hospital_treatment_details',
        'h_notes',
        'life_signs',
        'medical_certificates',
        'operative_protocols',
        'schedules',
        'schedule_details',
        'events',
        'orders',
        'order_details',
    ];

    public function up(): void
    {
        foreach ($this->clinicalTables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'created_by')) {
                    $table->foreignId('created_by')->nullable()->after('updated_at')
                        ->constrained('users')->nullOnDelete();
                }
                if (! Schema::hasColumn($tableName, 'updated_by')) {
                    $table->foreignId('updated_by')->nullable()->after('created_by')
                        ->constrained('users')->nullOnDelete();
                }
                if (! Schema::hasColumn($tableName, 'deleted_by')) {
                    $table->foreignId('deleted_by')->nullable()->after('updated_by')
                        ->constrained('users')->nullOnDelete();
                }
                if (! Schema::hasColumn($tableName, 'deleted_at')) {
                    $table->softDeletes()->after('deleted_by');
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->clinicalTables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
                foreach (['deleted_by', 'updated_by', 'created_by'] as $col) {
                    if (Schema::hasColumn($tableName, $col)) {
                        // dropConstrainedForeignId handles both the FK and
                        // the column on most drivers; SQLite ignores FK
                        // drop silently which is fine for the test suite.
                        try {
                            $table->dropConstrainedForeignId($col);
                        } catch (Throwable) {
                            $table->dropColumn($col);
                        }
                    }
                }
            });
        }
    }
};
