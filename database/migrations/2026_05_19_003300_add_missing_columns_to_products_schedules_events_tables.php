<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'unit')) {
                $table->string('unit')->nullable()->after('image');
            }
            if (! Schema::hasColumn('products', 'strength')) {
                $table->string('strength')->nullable()->after('unit');
            }
        });

        Schema::table('schedules', function (Blueprint $table) {
            if (! Schema::hasColumn('schedules', 'title')) {
                $table->string('title')->nullable()->after('id');
            }
            if (! Schema::hasColumn('schedules', 'start_time')) {
                $table->dateTime('start_time')->nullable()->after('ap_time');
            }
            if (! Schema::hasColumn('schedules', 'finish_time')) {
                $table->dateTime('finish_time')->nullable()->after('start_time');
            }
            if (! Schema::hasColumn('schedules', 'color')) {
                $table->string('color')->nullable()->after('status');
            }
        });

        Schema::table('events', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'allDay')) {
                $table->boolean('allDay')->default(false)->after('color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit', 'strength']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['title', 'start_time', 'finish_time', 'color']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('allDay');
        });
    }
};
