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
      Schema::create('rx_docfiles', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('rx_id');
        $table->string('filename');
        $table->foreign('rx_id', 'rx_id_fk_2041')->references('id')->on('rxes')->onDelete('cascade');
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
        Schema::dropIfExists('rx_docfiles');
    }
};
