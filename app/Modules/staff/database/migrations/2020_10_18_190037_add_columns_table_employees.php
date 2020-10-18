<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('attendance_id');
            $table->string('ar_st_name',25);
            $table->string('ar_nd_name',25);
            $table->string('ar_rd_name',25);
            $table->string('ar_th_name',25);
            $table->string('en_st_name',25);
            $table->string('en_nd_name',25);
            $table->string('en_rd_name',25);
            $table->string('en_th_name',25);
            $table->string('email',50)->nullable();
            $table->string('mobile1',12)->nullable();
            $table->string('mobile2',12)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['male','female'])->default('male');
            $table->string('address',100)->nullable();
            $table->enum('religion',['muslim','christian'])->default('muslim');
            $table->enum('native',['Arabic','English','French'])->default('Arabic');
            $table->enum('marital_status',['Single','Married','Separated','Divorced','Widowed'])->default('Single');
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
            $table->unsignedBigInteger('holiday_id')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('timetable_id')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('direct_manager_id')->nullable();
            $table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('timetable_id')->references('id')->on('timetables')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('direct_manager_id')->references('id')->on('employees');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {        
          $table->dropColumn('attendance_id');          
          $table->dropColumn('ar_st_name');
          $table->dropColumn('ar_nd_name');
          $table->dropColumn('ar_rd_name');
          $table->dropColumn('ar_th_name');
          $table->dropColumn('en_st_name');
          $table->dropColumn('en_nd_name');
          $table->dropColumn('en_rd_name');
          $table->dropColumn('en_th_name');
          $table->dropColumn('email');
          $table->dropColumn('mobile1');
          $table->dropColumn('mobile2');
          $table->dropColumn('dob');
          $table->dropColumn('gender');
          $table->dropColumn('address');
          $table->dropColumn('religion');
          $table->dropColumn('native');
          $table->dropColumn('marital_status');
          $table->dropColumn('health_details');
          $table->dropColumn('national_id');
          $table->dropColumn('military_service');          
          $table->dropColumn('hiring_date');
          $table->dropColumn('job_description');
          $table->dropColumn('has_contract');
          $table->dropColumn('contract_type');
          $table->dropColumn('contract_date');
          $table->dropColumn('contract_end_date');
          $table->dropColumn('previous_experience');
          $table->dropColumn('institution');
          $table->dropColumn('qualification');
          $table->dropColumn('social_insurance');
          $table->dropColumn('social_insurance_num');
          $table->dropColumn('social_insurance_date');
          $table->dropColumn('medical_insurance');
          $table->dropColumn('medical_insurance_num');
          $table->dropColumn('medical_insurance_date');
          $table->dropColumn('exit_interview_feedback');
          $table->dropColumn('leave_date');
          $table->dropColumn('leave_reason');
          $table->dropColumn('leaved');
          $table->dropColumn('salary');
          $table->dropColumn('salary_suspend');
          $table->dropColumn('salary_mode');
          $table->dropColumn('salary_bank_name');
          $table->dropColumn('bank_account');
          $table->dropColumn('leave_balance');
          $table->dropColumn('bus_value');
          $table->dropColumn('vacation_allocated');
          $table->dropForeign('employees_holiday_id_foreign');
          $table->dropColumn('holiday_id');
          $table->dropForeign('employees_sector_id_foreign');
          $table->dropColumn('sector_id');
          $table->dropForeign('employees_department_id_foreign');
          $table->dropColumn('department_id');
          $table->dropForeign('employees_section_id_foreign');
          $table->dropColumn('section_id');
          $table->dropForeign('employees_position_id_foreign');
          $table->dropColumn('position_id');
          $table->dropForeign('employees_timetable_id_foreign');
          $table->dropColumn('timetable_id');
          $table->dropForeign('employees_admin_id_foreign');
          $table->dropColumn('admin_id');
          $table->dropColumn('deleted_at');
        });
    }
}
