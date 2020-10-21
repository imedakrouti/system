<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewFullEmployeeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW full_employee_data 
        AS 
        select `employees`.* , `departments`.`en_department`, `departments`.`ar_department`, `sectors`.`en_sector`,
        `sectors`.`ar_sector`, `sections`.`en_section`, `sections`.`ar_section`, `positions`.`en_position`,
        `positions`.`ar_position` ,`timetables`.`en_timetable` ,`timetables`.`ar_timetable`
        from `employees` 
        left join `departments` on `employees`.`department_id` = `departments`.`id` 
        left join `sectors` on `employees`.`sector_id` = `sectors`.`id` 
        left join `sections` on `employees`.`section_id` = `sections`.`id` 
        left join `positions` on `employees`.`position_id` = `positions`.`id`
        left join `timetables` on `employees`.`timetable_id` = `timetables`.`id`
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('view_full_employee_data');
    }
}
