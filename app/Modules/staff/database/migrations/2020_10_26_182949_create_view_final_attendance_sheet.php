<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewFinalAttendanceSheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW final_attendance_sheet
            AS
            SELECT
            employees.en_st_name,employees.en_nd_name,employees.id as employee_id,
            (SELECT ar_timetable FROM timetables WHERE timetables.id = employees.timetable_id) as ar_timetable, 
            (SELECT en_timetable FROM timetables WHERE timetables.id = employees.timetable_id) as en_timetable, 
            (SELECT on_duty_time FROM timetables WHERE timetables.id = employees.timetable_id) as on_duty_time, 
            (SELECT off_duty_time FROM timetables WHERE timetables.id = employees.timetable_id) as off_duty_time, 
            (SELECT beginning_in FROM timetables WHERE timetables.id = employees.timetable_id) as beginning_in, 
            (SELECT ending_in FROM timetables WHERE timetables.id = employees.timetable_id) as ending_in, 
            (SELECT beginning_out FROM timetables WHERE timetables.id = employees.timetable_id) as beginning_out, 
            (SELECT ending_out FROM timetables WHERE timetables.id = employees.timetable_id) as ending_out, 
            
            (SELECT saturday FROM timetables WHERE timetables.id = employees.timetable_id) as saturday, 
            (SELECT sunday FROM timetables WHERE timetables.id = employees.timetable_id) as sunday, 
            (SELECT monday FROM timetables WHERE timetables.id = employees.timetable_id) as monday, 
            (SELECT tuesday FROM timetables WHERE timetables.id = employees.timetable_id) as tuesday, 
            (SELECT wednesday FROM timetables WHERE timetables.id = employees.timetable_id) as wednesday, 
            (SELECT thursday FROM timetables WHERE timetables.id = employees.timetable_id) as thursday, 
            (SELECT friday FROM timetables WHERE timetables.id = employees.timetable_id) as friday, 
            
            (SELECT saturday_value FROM timetables WHERE timetables.id = employees.timetable_id) as saturday_value, 
            (SELECT sunday_value FROM timetables WHERE timetables.id = employees.timetable_id) as sunday_value, 
            (SELECT monday_value FROM timetables WHERE timetables.id = employees.timetable_id) as monday_value, 
            (SELECT tuesday_value FROM timetables WHERE timetables.id = employees.timetable_id) as wednesday_value, 
            (SELECT wednesday_value FROM timetables WHERE timetables.id = employees.timetable_id) as tuesday_value, 
            (SELECT thursday_value FROM timetables WHERE timetables.id = employees.timetable_id) as thursday_value,             
            (SELECT friday_value FROM timetables WHERE timetables.id = employees.timetable_id) as friday_value,    
            
            (SELECT daily_late_minutes FROM timetables WHERE timetables.id = employees.timetable_id) as daily_late_minutes,             
            (SELECT leave_minutes FROM timetables WHERE timetables.id = employees.timetable_id) as leave_min,             
            (SELECT day_absent_value FROM timetables WHERE timetables.id = employees.timetable_id) as day_absent_value,             
            (SELECT no_attend FROM timetables WHERE timetables.id = employees.timetable_id) as noAttend,             
            (SELECT no_leave FROM timetables WHERE timetables.id = employees.timetable_id) as noLeave,             
            attendance_sheet_dates.*,

            IF(`clock_in` IS NULL && `clock_out`  IS NULL &&
			(
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Saturday' &&
            (SELECT saturday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            OR
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Sunday' &&
            (SELECT sunday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            OR
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Monday' &&
            (SELECT monday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            OR
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Tuesday' &&
            (SELECT tuesday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            OR
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Wednesday' &&
            (SELECT wednesday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            OR
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Thursday' &&
            (SELECT thursday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            OR
            DAYNAME(`attendance_sheet_dates`.`selected_date`) = 'Friday' &&
            (SELECT friday FROM timetables WHERE timetables.id = employees.timetable_id) = 'Enable'
            
            ),
            
            'True','') AS absent

            FROM attendance_sheet_dates
            INNER JOIN employees
            ON attendance_sheet_dates.attendance_id = employees.attendance_id
             "
          );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_final_attendance_sheet');
    }
}
