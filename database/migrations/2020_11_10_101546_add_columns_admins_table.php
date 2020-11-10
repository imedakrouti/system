<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('admins', function (Blueprint $table) {
            $table->string('ar_name')->nullable();
            $table->enum('domain_role',['owner','super admin','super visor','manager','staff','teacher','none'])->nullable();
        });
        Schema::connection('mysql2')->table('admins', function (Blueprint $table) {
            $table->string('ar_name')->nullable();
            $table->enum('domain_role',['owner','super admin','super visor','manager','staff','teacher','none'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('admins', function (Blueprint $table) {
            $table->dropColumn('ar_name');
            $table->dropColumn('domain_role');
        });
        Schema::connection('mysql2')->table('admins', function (Blueprint $table) {
            $table->dropColumn('ar_name');
            $table->dropColumn('domain_role');
        });
    }
}
