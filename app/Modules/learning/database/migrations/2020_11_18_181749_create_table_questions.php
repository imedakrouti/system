<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('question_type',['multiple_choice','true_false','matching','complete','essay'])->default('multiple_choice');
            $table->string('question_text');
            $table->integer('mark');
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
        Schema::connection('mysql2')->create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('question_type',['multiple_choice','true_false','matching','complete','essay'])->default('multiple_choice');
            $table->string('question_text');
            $table->integer('mark');
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('admin_id');
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
        Schema::connection('mysql')->dropIfExists('questions');
        Schema::connection('mysql2')->dropIfExists('questions');
    }
}
