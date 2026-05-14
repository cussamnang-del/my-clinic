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
        Schema::create('document_lives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->string('coltype')->nullable();
            $table->string('colfield')->nullable();
            $table->string('coldesr')->nullable();
            $table->integer('num');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('document_id', 'document_id_fk_2001')->references('id')->on('documents')->onDelete('cascade');
        });
        $permissions = [
            [
                'title' => 'document_life_management_access',
                'group' => 'Document_life Management',
            ],
            [
                'title' => 'document_life_create',
                'group' => 'Document_life',
            ],
            [
                'title' => 'document_life_edit',
                'group' => 'Document_life',
            ],
            [
                'title' => 'document_life_show',
                'group' => 'Document_life',
            ],
            [
                'title' => 'document_life_delete',
                'group' => 'Document_life',
            ],
            [
                'title' => 'document_life_access',
                'group' => 'Document_life',
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
        Schema::dropIfExists('document_lives');
    }
};
