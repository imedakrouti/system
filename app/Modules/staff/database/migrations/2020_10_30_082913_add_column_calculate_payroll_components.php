<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCalculatePayrollComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_components', function (Blueprint $table) {
            $table->string('calculate')->nullable();
            $table->integer('total_employees')->nullable();
            $table->integer('sort')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_components', function (Blueprint $table) {
            $table->dropColumn('calculate');
            $table->dropColumn('total_employees');
            $table->dropColumn('sort');
        });
    }
}
