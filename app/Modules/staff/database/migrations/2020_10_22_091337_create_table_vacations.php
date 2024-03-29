<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVacations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_vacation');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('count');            
            $table->string('file_name')->nullable();
            $table->enum('approval1',['Accepted','Rejected','Canceled','Pending'])->default('Pending');
            $table->enum('approval2',['Accepted','Rejected','Canceled','Pending'])->default('Pending');
            $table->enum('vacation_type',['Start work','End work','Sick leave','Regular vacation','Vacation without pay','Work errand','Training','Casual vacation']);
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('substitute_employee_id')->nullable();
            $table->foreign('substitute_employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('vacations');
    }
}
