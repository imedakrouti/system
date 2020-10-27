<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('period');
            $table->double('value',10,2);
            $table->date('from_date');
            $table->date('to_date');   
            $table->string('salary_mode')->nullable();
            $table->string('salary_bank_name')->nullable();
            $table->string('salary_bank_account')->nullable();  
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('salary_component_id');
            $table->foreign('salary_component_id')->references('id')->on('salary_components')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('payroll_sheet_id');
            $table->foreign('payroll_sheet_id')->references('id')->on('payroll_sheets')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('payroll_components');
    }
}
