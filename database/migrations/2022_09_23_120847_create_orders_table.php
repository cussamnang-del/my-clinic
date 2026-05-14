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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('order_date');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('chief_complain')->nullable();
            $table->string('past_history')->nullable();
            $table->string('blood_test')->nullable();
            $table->string('orl_ent')->nullable();
            $table->string('ultra_sound')->nullable();
            $table->string('ecg')->nullable();
            $table->string('x_ray')->nullable();
            $table->string('et_at')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('recommendation')->nullable();
            $table->enum('order_type', ['Medicine', 'Injection'])->default('Medicine');
            $table->foreign('document_id', 'document_id_fk_2053')
                ->references('id')->on('documents')
                ->onDelete('cascade');
            $table->foreign('customer_id', 'customer_id_fk_2054')
                ->references('id')->on('customers')
                ->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2055')
                ->references('id')->on('users')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
