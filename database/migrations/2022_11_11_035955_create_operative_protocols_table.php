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
        Schema::create('operative_protocols', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('time')->nullable();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('operater')->nullable();
            $table->string('aide')->nullable();
            $table->string('anesth')->nullable();
            $table->string('diapre')->nullable();
            $table->string('diaper')->nullable();
            $table->string('indication')->nullable();
            $table->string('position')->nullable();
            $table->longtext('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('status')->default(1);
            $table->foreign('document_id', 'document_id_fk_2062')
                ->references('id')->on('documents')
                ->onDelete('cascade');
            $table->foreign('customer_id', 'customer_id_fk_2063')
                ->references('id')->on('customers')
                ->onDelete('cascade');
            $table->foreign('user_id', 'user_id_fk_2064')
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
        Schema::dropIfExists('operative_protocols');
    }
};
