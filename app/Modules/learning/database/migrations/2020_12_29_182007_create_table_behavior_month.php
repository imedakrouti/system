<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBehaviorMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('behaviour_month', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('month_id')->nullable();
        //     $table->foreign('month_id')->references('id')->on('months')->onDelete('cascade')->onUpdate('cascade'); 
        //     $table->unsignedBigInteger('behaviour_id')->nullable();
        //     $table->foreign('behaviour_id')->references('id')->on('behaviours')->onDelete('cascade')->onUpdate('cascade'); 
        //     $table->unsignedBigInteger('year_id')->nullable();
        //     $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade')->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('behaviour_month');
    }
}
