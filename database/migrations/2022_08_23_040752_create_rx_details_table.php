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
        Schema::create('rx_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rx_id');
            $table->unsignedBigInteger('doctor_description_id');
            $table->unsignedBigInteger('user_id');
            $table->string('description')->nullable();
            $table->string('result')->nullable();
            $table->foreign('rx_id', 'rx_id_fk_2038')->references('id')->on('rxes')->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2039')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_description_id', 'doctor_description_id_fk_2040')->references('id')->on('doctor_descriptions')->onDelete('cascade');
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
        Schema::dropIfExists('rx_details');
    }
};
