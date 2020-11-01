<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsEmployeesStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('ar_rd_name');
            $table->dropColumn('ar_th_name');
            $table->dropColumn('en_rd_name');
            $table->dropColumn('en_th_name');
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->string('ar_rd_name')->nullable();
            $table->string('ar_th_name')->nullable();
            $table->string('en_rd_name')->nullable();
            $table->string('en_th_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('ar_rd_name');
            $table->dropColumn('ar_th_name');
            $table->dropColumn('en_rd_name');
            $table->dropColumn('en_th_name');
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->string('ar_rd_name')->nullable();
            $table->string('ar_th_name')->nullable();
            $table->string('en_rd_name')->nullable();
            $table->string('en_th_name')->nullable();
        });
    }
}
