<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('arabicDepartment',20);
            $table->string('englishDepartment',20);
            $table->integer('sort')->nullable();
            $table->integer('balanceDepartmentLeave')->nullable();
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('sector_id')->references('id')->on('sectors');
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
        Schema::dropIfExists('departments');
    }
}
