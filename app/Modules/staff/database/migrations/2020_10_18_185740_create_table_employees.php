<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('attendance_id')->unique();
            $table->string('ar_st_name',25)->nullable();
            $table->string('ar_nd_name',25)->nullable();
            $table->string('ar_rd_name',25)->nullable();
            $table->string('ar_th_name',25)->nullable();
            $table->string('en_st_name',25)->nullable();
            $table->string('en_nd_name',25)->nullable();
            $table->string('en_rd_name',25)->nullable();
            $table->string('en_th_name',25)->nullable();
            $table->string('email',50)->nullable();
            $table->string('mobile1',12)->nullable();
            $table->string('mobile2',12)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['male','female'])->default('male')->nullable();
            $table->string('address',100)->nullable();
            $table->enum('religion',['muslim','christian'])->default('muslim')->nullable();
            $table->enum('native',['Arabic','English','French','German','Italy'])->default('Arabic')->nullable();
            $table->enum('marital_status',['Single','Married','Separated','Divorced','Widowed'])->default('Single')->nullable();
            $table->string('health_details')->nullable();
            $table->string('national_id')->nullable();
            $table->enum('military_service',['Exempted','Finished'])->nullable();
            $table->date('hiring_date')->nullable();
            $table->string('job_description')->nullable();
            $table->enum('has_contract',['Yes','No'])->default('No')->nullable();
            $table->enum('contract_type',['Full Time','Part Time'])->default('Full Time')->nullable();            
            $table->date('contract_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->text('previous_experience')->nullable();
            $table->string('institution')->nullable();
            $table->string('qualification')->nullable();
            $table->enum('social_insurance',['Yes','No'])->default('No')->nullable();
            $table->string('social_insurance_num')->nullable();
            $table->date('social_insurance_date')->nullable();
            $table->enum('medical_insurance',['Yes','No'])->default('No')->nullable();
            $table->string('medical_insurance_num')->nullable();
            $table->date('medical_insurance_date')->nullable();
            $table->string('exit_interview_feedback')->nullable();
            $table->date('leave_date')->nullable();
            $table->text('leave_reason')->nullable();
            $table->enum('leaved',['Yes','No'])->nullable()->default('No');
            $table->decimal('salary')->nullable();
            $table->enum('salary_suspend',['Yes','No'])->default('No');
            $table->enum('salary_mode',['Cash','Bank'])->default('Cash')->nullable();
            $table->string('salary_bank_name')->nullable();
            $table->string('bank_account')->nullable();                                    
            $table->integer('leave_balance')->nullable();
            $table->integer('bus_value')->nullable();
            $table->integer('vacation_allocated')->nullable();            
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('timetable_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('direct_manager_id')->nullable();            
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('timetable_id')->references('id')->on('timetables')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('direct_manager_id')->references('id')->on('employees');
            $table->foreign('user_id')->references('id')->on('admins');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
