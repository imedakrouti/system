<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRegistrationStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name_status',50);
            $table->string('en_name_status',50);
            $table->string('description')->nullable();
            $table->enum('shown',['show','hidden'])->default('hidden');
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
        Schema::dropIfExists('registration_status');
    }
}
