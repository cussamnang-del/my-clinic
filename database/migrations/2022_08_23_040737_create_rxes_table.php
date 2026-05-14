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
        Schema::create('rxes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('rx_date');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id');
            $table->string('rx_note');
            $table->boolean('status')->default(1);
            $table->foreign('customer_id', 'customer_id_fk_2036')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('document_id', 'document_id_fk_2036')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2037')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('rxes');
    }
};
