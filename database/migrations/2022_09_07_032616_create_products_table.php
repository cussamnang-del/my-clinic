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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('p_name');
            $table->string('p_code');
            $table->decimal('p_price');
            $table->unsignedBigInteger('group_id')->default(1);
            $table->unsignedBigInteger('type_id')->default(1);
            $table->text('description')->nullable();
            $table->string('country');
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        $permissions = [
            [
                'title' => 'product_management_access',
                'group' => 'Product Management',
            ],
            [
                'title' => 'product_create',
                'group' => 'Product',
            ],
            [
                'title' => 'product_edit',
                'group' => 'Product',
            ],
            [
                'title' => 'product_show',
                'group' => 'Product',
            ],
            [
                'title' => 'product_delete',
                'group' => 'Product',
            ],
            [
                'title' => 'product_access',
                'group' => 'Product',
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
        Schema::dropIfExists('products');
    }
};
