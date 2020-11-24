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
            $table->enum('question_type',['multiple_choice','true_false','matching','complete','essay','paragraph'])->default('multiple_choice');
            $table->text('question_text')->nullable();
            $table->integer('mark');
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('exam_id')->nullable()->nullable();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('homework_id')->nullable()->nullable();
            $table->foreign('homework_id')->references('id')->on('homeworks')->onDelete('cascade')->onUpdate('cascade');                        
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
      
    }
}
