<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'hospitals',
        'items',
        'item_groups',
        'item_types',
        'products',
        'doctor_description',
        'company_information',
        'rooms',
        'how_to_uses',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasColumn($table, 'created_by')) {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    $blueprint->foreignId('created_by')->nullable()->after('updated_at')
                        ->constrained('users')->nullOnDelete();
                    $blueprint->foreignId('updated_by')->nullable()->after('created_by')
                        ->constrained('users')->nullOnDelete();
                    $blueprint->foreignId('deleted_by')->nullable()->after('updated_by')
                        ->constrained('users')->nullOnDelete();

                    if (! Schema::hasColumn($table, 'deleted_at')) {
                        $blueprint->softDeletes()->after('deleted_by');
                    }
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->dropForeign([$table.'_created_by_foreign']);
                $blueprint->dropForeign([$table.'_updated_by_foreign']);
                $blueprint->dropForeign([$table.'_deleted_by_foreign']);
                $blueprint->dropColumn(['created_by', 'updated_by', 'deleted_by']);

                if (Schema::hasColumn($table, 'deleted_at')) {
                    $blueprint->dropSoftDeletes();
                }
            });
        }
    }
};
