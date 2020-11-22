<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('post_text');
            $table->string('image')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('url')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('classroom_id');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade')->onUpdate('cascade');                        
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });

        Schema::connection('mysql2')->create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('post_text');
            $table->string('image')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('url')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('classroom_id');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade')->onUpdate('cascade');                        
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
        Schema::connection('mysql')->dropIfExists('posts');
        Schema::connection('mysql2')->dropIfExists('posts');
    }
}
