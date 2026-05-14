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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('unit')->nullable();
            $table->string('strength')->nullable();
            $table->float('qty')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('total')->nullable();
            $table->string('how_to_use')->nullable();
            $table->string('before_after')->nullable();
            $table->foreign('order_id', 'order_id_fk_2056')
                ->references('id')->on('orders')
                ->onDelete('cascade');
            $table->foreign('product_id', 'product_id_fk_2057')
                ->references('id')->on('products')
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
        Schema::dropIfExists('order_details');
    }
};
