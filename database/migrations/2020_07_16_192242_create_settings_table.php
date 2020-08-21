<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_school_name')->nullable();
            $table->string('en_school_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('icon')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('contact1',50)->nullable();
            $table->string('contact2',50)->nullable();
            $table->string('contact3',50)->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->string('fb',100)->nullable();
            $table->string('yt',100)->nullable();            
            $table->enum('status',['open','close'])->default('open');
            $table->string('msg_maintenance')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
