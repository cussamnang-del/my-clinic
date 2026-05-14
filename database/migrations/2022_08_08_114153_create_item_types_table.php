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
        Schema::create('item_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_group_id');
            $table->string('name');
            $table->boolean('status')->default(0);
            $table->foreign('item_group_id', 'item_group_id_fk_2030')->references('id')->on('item_groups')->onDelete('cascade');
            $table->timestamps();
        });
        $permissions = [
            [
                'title' => 'item_type_management_access',
                'group' => 'Item_Type Management',
            ],
            [
                'title' => 'item_type_create',
                'group' => 'Item_Type',
            ],
            [
                'title' => 'item_type_edit',
                'group' => 'Item_Type',
            ],
            [
                'title' => 'item_type_show',
                'group' => 'Item_Type',
            ],
            [
                'title' => 'item_type_delete',
                'group' => 'Item_Type',
            ],
            [
                'title' => 'item_type_access',
                'group' => 'Item_Type',
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
        Schema::dropIfExists('item_types');
    }
};
