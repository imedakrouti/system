<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_grade_name',30);
            $table->string('en_grade_name',30);
            $table->string('ar_grade_parent',30)->nullable();
            $table->string('en_grade_parent',30)->nullable();
            $table->integer('from_age_year')->nullable();
            $table->integer('from_age_month')->nullable();
            $table->integer('to_age_year')->nullable();
            $table->integer('to_age_month')->nullable();            
            $table->integer('sort');
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
        Schema::dropIfExists('grades');
    }
}
