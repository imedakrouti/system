<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesWeeksMonths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('month_behaviour', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('behaviour_id');
            $table->foreign('behaviour_id')->references('id')->on('behaviours')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('month_homework', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('homework_id');
            $table->foreign('homework_id')->references('id')->on('homeworks')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('month_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('month_absence_session', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('absence_session_id');
            $table->foreign('absence_session_id')->references('id')->on('absence_sessions')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('week_behaviour', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('week_id');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('behaviour_id');
            $table->foreign('behaviour_id')->references('id')->on('behaviours')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('week_homework', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('week_id');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('homework_id');
            $table->foreign('homework_id')->references('id')->on('homeworks')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('week_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('week_id');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::connection('mysql')->create('week_absence_session', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('week_id');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('absence_session_id');
            $table->foreign('absence_session_id')->references('id')->on('absence_sessions')->onDelete('cascade')->onUpdate('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('month_behaviour');
        Schema::connection('mysql')->dropIfExists('month_homework');
        Schema::connection('mysql')->dropIfExists('month_exam');
        Schema::connection('mysql')->dropIfExists('month_absence_session');

        Schema::connection('mysql')->dropIfExists('week_behaviour');
        Schema::connection('mysql')->dropIfExists('week_homework');
        Schema::connection('mysql')->dropIfExists('week_exam');
        Schema::connection('mysql')->dropIfExists('week_absence_session');
    }
}
