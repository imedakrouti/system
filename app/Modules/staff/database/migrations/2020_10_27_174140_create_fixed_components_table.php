<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount',8,2)->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('salary_component_id');
            $table->foreign('salary_component_id')->references('id')->on('salary_components')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('fixed_components');
    }
}
