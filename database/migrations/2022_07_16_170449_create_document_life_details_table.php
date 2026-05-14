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
        Schema::create('document_life_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_lives_id');
            $table->string('colfield')->nullable();
            $table->string('coldesr')->nullable();
            $table->string('coldate')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('document_lives_id', 'document_lives_id_fk_2002')->references('id')->on('document_lives')->onDelete('cascade');
        });
        $permissions = [
            [
                'title' => 'document_life_detail_management_access',
                'group' => 'Document_life_detail Management',
            ],
            [
                'title' => 'document_life_detail_create',
                'group' => 'Document_life_detail',
            ],
            [
                'title' => 'document_life_detail_edit',
                'group' => 'Document_life_detail',
            ],
            [
                'title' => 'document_life_detail_show',
                'group' => 'Document_life_detail',
            ],
            [
                'title' => 'document_life_detail_delete',
                'group' => 'Document_life_detail',
            ],
            [
                'title' => 'document_life_detail_access',
                'group' => 'Document_life_detail',
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
        Schema::dropIfExists('document_life_details');
    }
};
