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
        Schema::create('h_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->date('date')->nullable();
            $table->string('mob')->nullable();
            $table->string('dia')->nullable();
            $table->string('todo')->nullable();
            $table->string('comment')->nullable();
            $table->foreign('hospital_id', 'hospital_id_fk_2049')
                  ->references('id')->on('hospitals')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('h_notes');
    }
};
