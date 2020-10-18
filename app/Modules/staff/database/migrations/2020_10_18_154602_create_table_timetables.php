<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTimetables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_timetable',50);
            $table->string('en_timetable',50);
            $table->string('description')->nullable();
            $table->time('on_duty_time');
            $table->time('off_duty_time');
            $table->time('beginning_in');
            $table->time('ending_in');
            $table->time('beginning_out');
            $table->time('ending_out');
            $table->string('saturday')->default('Enable')->nullable();
            $table->string('sunday')->default('Enable')->nullable();
            $table->string('monday')->default('Enable')->nullable();
            $table->string('tuesday')->default('Enable')->nullable();
            $table->string('wednesday')->default('Enable')->nullable();
            $table->string('thursday')->default('Enable')->nullable();
            $table->string('friday')->default('Enable')->nullable();  
            $table->integer('saturday_value')->nullable()->default(1);
            $table->integer('sunday_value')->nullable()->default(1);
            $table->integer('monday_value')->nullable()->default(1);
            $table->integer('tuesday_value')->nullable()->default(1);
            $table->integer('wednesday_value')->nullable()->default(1);
            $table->integer('thursday_value')->nullable()->default(1);
            $table->integer('friday_value')->nullable()->default(1);
            $table->integer('daily_late_minutes')->nullable();
            $table->float('day_absent_value',4,1)->nullable();
            $table->integer('no_attend')->nullable();
            $table->float('no_leave',4,1)->nullable();
            $table->float('check_in_before_leave',4,1)->nullable();
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
        Schema::dropIfExists('timetables');
    }
}
