<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('attendanceId');
            $table->dropColumn('enEmployeeName');
            $table->dropColumn('enFatherName');
            $table->dropColumn('enGrandName');
            $table->dropColumn('enFamilyName');
            $table->dropColumn('arEmployeeName');
            $table->dropColumn('arFatherName');
            $table->dropColumn('arGrandName');
            $table->dropColumn('arFamilyName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('attendanceId')->unique();
            $table->string('enEmployeeName');
            $table->string('enFatherName');
            $table->string('enGrandName')->nullable();
            $table->string('enFamilyName')->nullable();
            $table->string('arEmployeeName');
            $table->string('arFatherName');
            $table->string('arGrandName')->nullable();
            $table->string('arFamilyName')->nullable();
        });
    }
}
