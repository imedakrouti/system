<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name');
            $table->string('ar_shortcut');
            $table->string('en_name');
            $table->string('en_shortcut');
            $table->string('image')->nullable();
            $table->integer('sort');               
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
        Schema::connection('mysql')->dropIfExists('subjects');
       
    }
}
