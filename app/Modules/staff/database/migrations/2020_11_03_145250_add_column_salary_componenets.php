<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSalaryComponenets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_components', function (Blueprint $table) {
            $table->unsignedBigInteger('payroll_sheet_id');
            $table->foreign('payroll_sheet_id')->references('id')->on('payroll_sheets')->onDelete('cascade')->onUpdate('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_components', function (Blueprint $table) {
            $table->dropForeign('salary_components_payroll_sheet_id_foreign');            
            $table->dropColumn('payroll_sheet_id');
        });
    }
}
