<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableDeduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deductions', function (Blueprint $table) {
            $table->unsignedBigInteger('approval_one_user')->nullable();         
            $table->unsignedBigInteger('approval_two_user')->nullable();    
            $table->unsignedBigInteger('leave_permission_id')->nullable();       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deductions', function (Blueprint $table) {
            $table->dropColumn('approval_one_user');            
            $table->dropColumn('approval_two_user');
            $table->dropColumn('leave_permission_id');
        });
    }
}
