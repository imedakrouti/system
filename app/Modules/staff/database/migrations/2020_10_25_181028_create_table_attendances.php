<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');                         
            $table->enum('mode',['insert','import'])->default('insert')->nullable();             
            $table->unsignedBigInteger('attendance_id');            
            $table->enum('status_attendance',['In','Out'])->default('In');
            $table->datetime('time_attendance');
            $table->unsignedBigInteger('attendance_sheet_id');
            $table->foreign('attendance_sheet_id')->references('id')->on('attendance_sheets')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('attendances');
    }
}
