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
			Schema::create('medical_certificates', function (Blueprint $table) {
					$table->id();
					$table->date('date');
					$table->string('time')->nullable();
					$table->unsignedBigInteger('document_id');
					$table->unsignedBigInteger('customer_id');
					$table->string('chief_complain')->nullable();
					$table->string('past_history')->nullable();
					$table->string('examination')->nullable();
					$table->string('diagnosis')->nullable();
					$table->string('treatment')->nullable();
					$table->boolean('is_sick')->default(0);
					$table->date('from_date');
					$table->date('to_date');
					$table->string('attending')->nullable();
					$table->boolean('is_other')->default(false);
					$table->longtext('note')->nullable();
					$table->unsignedBigInteger('user_id')->nullable();
					$table->boolean('status')->default(1);
					$table->foreign('document_id', 'document_id_fk_2065')
								->references('id')->on('documents')
								->onDelete('cascade');
					$table->foreign('customer_id', 'customer_id_fk_2066')
								->references('id')->on('customers')
								->onDelete('cascade');
					$table->foreign('user_id', 'user_id_fk_2067')
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
        Schema::dropIfExists('medical_certificates');
    }
};
