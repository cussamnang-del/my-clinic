<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Reagent / consumable lot tracking.
 *
 * ISO 15189:2022 §6.4.3 ("Reagents and consumables") requires the lab
 * to record, for every reagent batch in use:
 *   - Lot number and manufacturer.
 *   - Receipt date and expiry date.
 *   - Open date (in-use stability is calculated from this).
 *   - QC acceptance (separate concern, handled by ResultRelease in Phase 2).
 *
 * The model layer derives:
 *   - is_expired = now() > expires_at
 *   - is_open_use_expired = open_use_days_allowed && opened_at + days < now()
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reagent_lots', function (Blueprint $table) {
            $table->id();

            // Soft pointer to the analyte / catalogue item this lot is for.
            // Nullable because some sites keep a generic reagent register
            // and only later link to specific tests.
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete();

            $table->string('lot_number', 128);
            $table->string('manufacturer', 128)->nullable();

            $table->date('received_at')->nullable();
            $table->date('opened_at')->nullable();
            $table->date('expires_at');

            // If non-null, the maximum number of days the reagent can be used
            // after `opened_at`. Used to flag in-use expiry separately from
            // shelf-life expiry.
            $table->unsignedSmallInteger('open_use_days_allowed')->nullable();

            // received / in_use / expired / quarantine / depleted
            $table->string('status', 32)->default('received');

            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Most queries: "is this lot still usable?" → filter on
            // (item_id, status, expires_at).
            $table->index(['item_id', 'status']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reagent_lots');
    }
};
