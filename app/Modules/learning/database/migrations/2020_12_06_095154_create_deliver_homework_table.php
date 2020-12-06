<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('deliver_homework', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('user_answer')->nullable();
            $table->integer('mark')->default(0);
            $table->string('remark')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('homework_id');
            $table->foreign('homework_id')->references('id')->on('homeworks')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::connection('mysql')->dropIfExists('deliver_homework');
    }
}
