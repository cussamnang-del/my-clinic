<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('age', 3)->nullable();
            $table->dateTime('dob')->nullable();
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('commune_id');
            $table->unsignedBigInteger('village_id');
            $table->string('phone_no')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('photo')->default('avatar3.png');
            $table->dateTime('register_date')->nullable();
            $table->unsignedBigInteger('register_by')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        $permissions = [
            [
                'title' => 'customer_management_access',
                'group' => 'Customer Management',
            ],
            [
                'title' => 'customer_create',
                'group' => 'Customer',
            ],
            [
                'title' => 'customer_edit',
                'group' => 'Customer',
            ],
            [
                'title' => 'customer_show',
                'group' => 'Customer',
            ],
            [
                'title' => 'customer_delete',
                'group' => 'Customer',
            ],
            [
                'title' => 'customer_access',
                'group' => 'Customer',
            ],
        ];
        DB::table('permissions')->insert($permissions);
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
