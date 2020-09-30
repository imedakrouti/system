<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableReportContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_contents', function (Blueprint $table) {
            $table->text('daily_request')->nullable();
            $table->text('proof_enrollment')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_contents', function (Blueprint $table) {
            $table->dropColumn('daily_request');
            $table->dropColumn('proof_enrollment');
        });
    }
}
