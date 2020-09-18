<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_migration', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_grade_id');
            $table->foreign('from_grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('to_grade_id');
            $table->foreign('to_grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('set_migration');
    }
}
