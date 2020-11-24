<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lesson_title');
            $table->string('description')->nullable();
            $table->text('explanation');
            $table->string('video_url')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('sort');
            $table->enum('visibility',['show','hide'])->default('show');
            $table->enum('approval',['pending','accepted'])->default('pending');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('playlist_id')->nullable();
            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('user_approval')->nullable();
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
        Schema::connection('mysql')->dropIfExists('lessons');
       
    }
}
