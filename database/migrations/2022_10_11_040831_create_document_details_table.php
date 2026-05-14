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
        Schema::create('document_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('service_name', ['bio', 'rx', 'h', 'ht', 'order']);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('document_id', 'document_id_fk_2058')
                ->references('id')->on('documents')
                ->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2058')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_details');
    }
};
