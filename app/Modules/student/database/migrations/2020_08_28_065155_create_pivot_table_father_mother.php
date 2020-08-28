<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableFatherMother extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('father_mother', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('father_id');
            $table->foreign('father_id')->references('id')->on('fathers')->onDelete('cascade')->onUpdate('cascade');;
            $table->unsignedBigInteger('mother_id');
            $table->foreign('mother_id')->references('id')->on('mothers')->onDelete('cascade')->onUpdate('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('father_mother');
    }
}
