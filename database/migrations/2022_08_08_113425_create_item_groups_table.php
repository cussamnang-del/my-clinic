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
        Schema::create('item_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
        $permissions = [
            [
                'title' => 'item_group_management_access',
                'group' => 'Item_Group Management',
            ],
            [
                'title' => 'item_group_create',
                'group' => 'Item_Group',
            ],
            [
                'title' => 'item_group_edit',
                'group' => 'Item_Group',
            ],
            [
                'title' => 'item_group_show',
                'group' => 'Item_Group',
            ],
            [
                'title' => 'item_group_delete',
                'group' => 'item_group',
            ],
            [
                'title' => 'item_group_access',
                'group' => 'item_group',
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
        Schema::dropIfExists('item_groups');
    }
};
