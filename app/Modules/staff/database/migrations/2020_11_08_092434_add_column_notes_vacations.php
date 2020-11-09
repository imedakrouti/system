<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNotesVacations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('vacations', function (Blueprint $table) {
            $table->string('notes')->nullable();
        });
        Schema::connection('mysql2')->table('vacations', function (Blueprint $table) {
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('vacations', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
        Schema::connection('mysql2')->table('vacations', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
}
