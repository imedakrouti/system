<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAuthorizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissioners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('commissioner_name',100);
            $table->string('id_number',15)->unique();
            $table->string('mobile',12)->unique();
            $table->string('notes');
            $table->enum('relation',['relative','driver'])->default('driver');
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('commissioners');
    }
}
