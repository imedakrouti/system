<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('user_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('user_answer')->nullable();
            $table->integer('mark')->default(0);
            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins');
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
        Schema::connection('mysql')->dropIfExists('user_answers');
    }
}
