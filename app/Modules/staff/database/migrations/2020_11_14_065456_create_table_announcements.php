<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAnnouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('announcement');
            $table->date('start_at');
            $table->date('end_at');
            $table->enum('domain_role',['owner','super admin','super visor','manager','staff','teacher','none'])->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins'); 
            $table->timestamps();
        });
        Schema::connection('mysql2')->create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('announcement');
            $table->date('start_at');
            $table->date('end_at');
            $table->enum('domain_role',['owner','super admin','super visor','manager','staff','teacher','none'])->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('announcements');
        Schema::connection('mysql2')->dropIfExists('announcements');
        
    }
}
