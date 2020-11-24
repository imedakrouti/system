<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPostType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('posts', function (Blueprint $table) {
            $table->enum('post_type',['post','exam','lesson'])->default('post');
            $table->string('description')->nullable();
        });

        Schema::connection('mysql2')->table('posts', function (Blueprint $table) {
            $table->enum('post_type',['post','exam','lesson'])->default('post');
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('posts', function (Blueprint $table) {
            $table->dropColumn('post_type');
            $table->dropColumn('description');
        });
        Schema::connection('mysql2')->table('posts', function (Blueprint $table) {
            $table->dropColumn('post_type');
            $table->dropColumn('description');
        });
    }
}
