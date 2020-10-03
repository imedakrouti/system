<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;
class CreateViewFullStudentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW full_student_data 
            AS 
            select students.id as student_id,students.student_type,students.ar_student_name,students.en_student_name,students.student_id_number,
            students.student_id_type,students.student_number,
            students.gender,students.nationality_id,students.religion,students.native_lang_id,students.second_lang_id,
            students.term,students.dob,
            students.code,students.reg_type,students.grade_id,students.division_id,students.student_image,
            students.submitted_application,students.submitted_name,
            students.submitted_id_number,students.submitted_mobile,students.school_id,students.transfer_reason,
            students.application_date,students.guardian_id,
            students.place_birth,students.return_country,students.registration_status_id,
            fathers.id as father_id,ar_st_name,ar_nd_name,ar_rd_name,ar_th_name,en_st_name,en_nd_name,en_rd_name,en_th_name,id_number,home_phone,mobile1,
            mobile2,job,email,qualification,facebook,whatsapp_number,educational_mandate,block_no,street_name,state,government,marital_status,
            recognition,
            CONCAT_WS(' ', ar_st_name, ar_nd_name, ar_rd_name, ar_th_name) AS ar_father_name,
            CONCAT_WS(' ', en_st_name, en_nd_name, en_rd_name, en_th_name) AS en_father_name,
            full_name,id_number_m,mobile1_m,mobile2_m,job_m,email_m,qualification_m,facebook_m,whatsapp_number_m,block_no_m,street_name_m,state_m,
            nationalities.ar_name_nat_female,nationalities.ar_name_nat_male,
            nationalities.en_name_nationality,
            grades.ar_grade_name,grades.en_grade_name,divisions.ar_division_name,divisions.en_division_name,
            schools.school_name,guardians.guardian_full_name,registration_status.ar_name_status,
            registration_status.en_name_status,
            lang.ar_name_lang,lang.en_name_lang
            
            from students
            inner join fathers on students.father_id = fathers.id
            inner join mothers on students.mother_id = mothers.id
            inner join nationalities on students.nationality_id = nationalities.id
            inner join languages on students.native_lang_id = languages.id
            inner join languages as lang on students.second_lang_id = lang.id
            inner join grades on students.grade_id = grades.id
            inner join divisions on students.division_id = divisions.id
            left join schools on students.school_id = schools.id  
            left join guardians on students.guardian_id = guardians.id
            inner join registration_status on students.registration_status_id = registration_status.id where ar_student_name <> ''                       
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        DB::statement('DROP VIEW full_student_data');
    }
}
