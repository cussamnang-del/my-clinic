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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('room_id');
            $table->date('h_date')->nullable();
            $table->string('h_note')->nullable();
            $table->boolean('status')->default(true);
            $table->foreign('customer_id', 'customer_id_fk_2044')
                    ->references('id')->on('customers')
                    ->onDelete('cascade');
            $table->foreign('document_id', 'document_id_fk_2045')
                    ->references('id')->on('documents')
                    ->onDelete('cascade');
            $table->foreign('room_id', 'room_id_fk_20441')
                    ->references('id')->on('rooms')
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
        Schema::dropIfExists('hospitals');
    }
};
