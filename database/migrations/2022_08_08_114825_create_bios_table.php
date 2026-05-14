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
        Schema::create('bios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item_id');
            $table->string('note')->nullable();
            $table->boolean('status')->default(0);
            $table->foreign('customer_id', 'customer_id_fk_2034')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('document_id', 'document_id_fk_2031')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2032')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id', 'item_id_fk_2033')->references('id')->on('items')->onDelete('cascade');
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
        Schema::dropIfExists('bios');
    }
};
