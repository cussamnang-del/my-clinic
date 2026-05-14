<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('documents', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('customer_id');
      $table->unsignedBigInteger('user_id');
      $table->dateTime('visit_date')->nullable();
      $table->dateTime('checkout_date')->nullable();
      $table->enum('checkout_status',['Y','N'])->nullable();
      $table->boolean('status')->default(0);
      $table->boolean('hospital_status')->default(0);
      $table->timestamps();
      $table->foreign('customer_id', 'customer_id_fk_1999')->references('id')->on('customers')->onDelete('cascade');
      $table->foreign('user_id', 'user_id_fk_2000')->references('id')->on('users')->onDelete('cascade');
    });
    $permissions = [
      [
        'title' => 'document_management_access',
        'group' => 'Document Management'
      ],
      [
        'title' => 'document_create',
        'group' => 'Document'
      ],
      [
        'title' => 'document_edit',
        'group' => 'Document'
      ],
      [
        'title' => 'document_show',
        'group' => 'Document'
      ],
      [
        'title' => 'document_delete',
        'group' => 'Document'
      ],
      [
        'title' => 'document_access',
        'group' => 'Document'
      ],
    ];
    DB::table('permissions')->insert($permissions);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('documents');
  }
};
