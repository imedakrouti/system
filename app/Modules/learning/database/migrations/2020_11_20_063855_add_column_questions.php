<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('questions', function (Blueprint $table) {
            $table->string('file_name')->nullable();
        });
        Schema::connection('mysql2')->table('questions', function (Blueprint $table) {
            $table->string('file_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('questions', function (Blueprint $table) {
            $table->dropColumn('file_name');
        });
        Schema::connection('mysql2')->table('questions', function (Blueprint $table) {
            $table->dropColumn('file_name');
        });
    }
}
