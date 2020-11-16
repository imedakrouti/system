<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGradeSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('grade_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
        Schema::connection('mysql2')->create('grade_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::connection('mysql')->dropIfExists('grade_subject');
        Schema::connection('mysql2')->dropIfExists('grade_subject');
    }
}
