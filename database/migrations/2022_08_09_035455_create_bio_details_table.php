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
    Schema::create('bio_details', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('bio_id');
      $table->unsignedBigInteger('customer_id');
      $table->unsignedBigInteger('document_id');
      $table->unsignedBigInteger('item_group_id');
      $table->unsignedBigInteger('item_type_id');
      $table->dateTime('date');
      $table->string('result')->nullable();
      $table->string('note')->nullable();
      $table->foreign('bio_id', 'bio_id_fk_2035')->references('id')->on('bios')->onDelete('cascade');
      $table->foreign('item_group_id', 'item_group_id_fk_10001')->references('id')->on('item_groups')->onDelete('cascade');
      $table->foreign('item_type_id', 'item_type_id_fk_10002')->references('id')->on('item_types')->onDelete('cascade');
      $table->foreign('customer_id', 'customer_id_fk_10003')->references('id')->on('customers')->onDelete('cascade');
      $table->foreign('document_id', 'document_id_fk_10004')->references('id')->on('documents')->onDelete('cascade');
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
    Schema::dropIfExists('bio_details');
  }
};
