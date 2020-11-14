<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInternalRegulations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('internal_regulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('internal_regulation_text')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins'); 
            $table->timestamps();
        });
        Schema::connection('mysql2')->create('internal_regulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('internal_regulation_text')->nullable();
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
        Schema::connection('mysql')->dropIfExists('internal_regulations');
        Schema::connection('mysql2')->dropIfExists('internal_regulations');
    }
}
