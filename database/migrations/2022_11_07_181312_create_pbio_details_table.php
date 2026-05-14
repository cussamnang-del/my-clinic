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
    Schema::create('pbio_details', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('pbio_id');
      $table->unsignedBigInteger('item_id');
      $table->boolean('status')->default(1);
      $table->foreign('pbio_id', 'pbio_id_fk_2061')
            ->references('id')->on('pbios')
            ->onDelete('cascade');
      $table->foreign('item_id', 'item_id_fk_2062')
            ->references('id')->on('items')
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
    Schema::dropIfExists('pbio_details');
  }
};
