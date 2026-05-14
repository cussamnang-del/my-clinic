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
        Schema::create('life_signs', function (Blueprint $table) {
            $table->id();
            $table->string('type_id');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        $permissions = [
            [
                'title' => 'lifesign_management_access',
                'group' => 'Lifesign Management',
            ],
            [
                'title' => 'lifesign_create',
                'group' => 'Lifesign',
            ],
            [
                'title' => 'lifesign_edit',
                'group' => 'Lifesign',
            ],
            [
                'title' => 'lifesign_show',
                'group' => 'Lifesign',
            ],
            [
                'title' => 'lifesign_delete',
                'group' => 'Lifesign',
            ],
            [
                'title' => 'lifesign_access',
                'group' => 'Lifesign',
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
        Schema::dropIfExists('life_signs');
    }
};
