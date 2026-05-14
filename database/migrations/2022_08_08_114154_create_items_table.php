<?php

use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('items', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('item_group_id');
      $table->unsignedBigInteger('item_type_id');
      $table->string('item_name')->nullable();
      $table->float('numset')->nullable();
      $table->string('uvn')->nullable();
      $table->float('item_price')->nullable();
      $table->boolean('status')->default(false);
      $table->foreign('item_group_id', 'item_group_id_fk_2020')->references('id')->on('item_groups')->onDelete('cascade');
      $table->foreign('item_type_id', 'item_type_id_fk_2021')->references('id')->on('item_types')->onDelete('cascade');
      $table->timestamps();
    });
    $permissions = [
      [
        'title' => 'item_management_access',
        'group' => 'Item Management'
      ],
      [
        'title' => 'item_create',
        'group' => 'Item'
      ],
      [
        'title' => 'item_edit',
        'group' => 'Item'
      ],
      [
        'title' => 'item_show',
        'group' => 'Item'
      ],
      [
        'title' => 'item_delete',
        'group' => 'Item'
      ],
      [
        'title' => 'item_access',
        'group' => 'Item'
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
    Schema::dropIfExists('items');
  }
};
