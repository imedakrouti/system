<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLeaveTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_leave',50);
            $table->string('en_leave',50);
            $table->enum('have_balance',['yes','no'])->default('no');
            $table->enum('activation',['active','inactive'])->default('active');
            $table->enum('target',['late','early'])->default('late');
            $table->enum('deduction',['yes','no'])->default('yes');
            $table->integer('deduction_allocated')->default(0);
            $table->integer('from_day')->default(1);
            $table->integer('to_day')->default(31);
            $table->enum('period',['this month','next month'])->default('this month');
            $table->integer('sort');
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
        Schema::dropIfExists('leave_types');
    }
}
