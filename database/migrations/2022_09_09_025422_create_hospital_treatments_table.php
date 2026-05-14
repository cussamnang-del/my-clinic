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
        Schema::create('hospital_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->date('ht_date')->nullable();
            $table->string('ht_time')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->float('qty')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->default(true);
            $table->foreign('hospital_id', 'hospital_id_fk_2046')
                  ->references('id')->on('hospitals')
                  ->onDelete('cascade');
            $table->foreign('product_id', 'product_id_fk_2047')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2048')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('hospital_treatments');
    }
};
