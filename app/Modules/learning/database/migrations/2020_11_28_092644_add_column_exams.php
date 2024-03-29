<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('exams', function (Blueprint $table) {
            $table->enum('auto_correct',['yes','no'])->default('no');
            $table->string('correct',10)->nullable();        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('exams', function (Blueprint $table) {
            $table->dropColumn('auto_correct');
            $table->dropColumn('correct');
        });
    }
}
