<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('villages', function (Blueprint $table) {
        $table->id();
        $table->string('type')->nullable();
        $table->string('code')->nullable();
        $table->string('name_kh')->nullable();
        $table->string('name_en')->nullable();
        $table->bigInteger('province_id')->nullable();
        $table->bigInteger('district_id')->nullable();
        $table->bigInteger('commune_id')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villages');
    }
};
