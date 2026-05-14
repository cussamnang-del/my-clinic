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
        Schema::create('hospital_treatment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_treatment_id');
            $table->unsignedBigInteger('hospital_treatment_product_id');
            $table->unsignedBigInteger('product_id');
            $table->float('qty')->nullable();
            $table->foreign('hospital_treatment_id', 'hospital_treatment_id_fk_2050')
                ->references('id')->on('hospital_treatments')
                ->onDelete('cascade');
            $table->foreign('product_id', 'product_id_fk_2051')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('hospital_treatment_product_id', 'hospital_treatment_product_id_fk_2052')
                ->references('product_id')->on('hospital_treatments')
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
        Schema::dropIfExists('hospital_treatment_details');
    }
};
