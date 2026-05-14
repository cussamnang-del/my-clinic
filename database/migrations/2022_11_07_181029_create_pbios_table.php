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
      Schema::create('pbios', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('customer_id');
        $table->unsignedBigInteger('document_id');
        $table->boolean('status')->default(1);
        $table->foreign('document_id', 'document_id_fk_2059')
              ->references('id')->on('documents')
              ->onDelete('cascade');
        $table->foreign('customer_id', 'customer_id_fk_2060')
              ->references('id')->on('customers')
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
      Schema::dropIfExists('pbios');
    }
};
