<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLeavePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_leave');
            $table->time('time_leave');
            $table->unsignedBigInteger('approval_one_user')->nullable();         
            $table->unsignedBigInteger('approval_two_user')->nullable();         
            $table->enum('approval1',['Accepted','Rejected','Canceled','Pending'])->default('Pending');
            $table->enum('approval2',['Accepted','Rejected','Canceled','Pending'])->default('Pending');
            $table->unsignedBigInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');            
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('approval_one_user')->references('id')->on('admins');
            $table->foreign('approval_two_user')->references('id')->on('admins');
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
        Schema::dropIfExists('leave_permissions');
    }
}
