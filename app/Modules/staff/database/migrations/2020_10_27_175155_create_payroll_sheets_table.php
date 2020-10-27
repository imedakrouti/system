<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sheet_name');
            $table->integer('from_day')->nullable();
            $table->integer('to_day')->nullable();
            $table->enum('end_period',['End Month','Next Month'])->default('End Month');        
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
        Schema::dropIfExists('payroll_sheets');
    }
}
