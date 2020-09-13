<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('attendanceId')->unique();
            $table->string('enEmployeeName');
            $table->string('enFatherName');
            $table->string('enGrandName')->nullable();
            $table->string('enFamilyName')->nullable();
            $table->string('arEmployeeName');
            $table->string('arFatherName');
            $table->string('arGrandName')->nullable();
            $table->string('arFamilyName')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
