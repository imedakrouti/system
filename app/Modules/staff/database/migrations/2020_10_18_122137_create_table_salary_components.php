<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSalaryComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_item',30);
            $table->string('en_item',30);
            $table->string('formula');
            $table->string('description')->nullable();
            $table->integer('sort');
            $table->enum('type',['fixed','variable'])->default('fixed');
            $table->enum('registration',['employee','payroll'])->default('payroll');
            $table->enum('calculate',['net','earn','info','deduction'])->default('info');
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
        Schema::dropIfExists('salary_components');
    }
}
