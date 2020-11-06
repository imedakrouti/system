<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceViewRemoveLates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->statement(
            "CREATE OR REPLACE VIEW last_main_view
            AS
            SELECT *,
            CASE
          		WHEN main_attendance_sheet.minutes_lates_after_request >= main_attendance_sheet.daily_late_minutes AND main_attendance_sheet.absent_after_holidays = '' THEN main_attendance_sheet.day_absent_value
            
           		WHEN main_attendance_sheet.no_attend = 0 AND main_attendance_sheet.no_leave = 1 THEN main_attendance_sheet.noLeave
           
                WHEN main_attendance_sheet.week = 'Saturday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = ''  THEN main_attendance_sheet.saturday_value
                WHEN main_attendance_sheet.week = 'Saturday' AND main_attendance_sheet.absent_after_holidays = 'True' 
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Sunday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.sunday_value
                WHEN main_attendance_sheet.week = 'Sunday' AND main_attendance_sheet.absent_after_holidays = 'True' 
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Monday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.monday_value
                WHEN main_attendance_sheet.week = 'Monday' AND main_attendance_sheet.absent_after_holidays = 'True'
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Tuesday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.tuesday_value
                WHEN main_attendance_sheet.week = 'Tuesday' AND main_attendance_sheet.absent_after_holidays = 'True' 
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Wednesday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.wednesday_value
                WHEN main_attendance_sheet.week = 'Wednesday' AND main_attendance_sheet.absent_after_holidays = 'True'  
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Thursday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.thursday_value
                WHEN main_attendance_sheet.week = 'Thursday' AND main_attendance_sheet.absent_after_holidays = 'True'  
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Friday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.friday_value
                WHEN main_attendance_sheet.week = 'Friday' AND main_attendance_sheet.absent_after_holidays = 'True'  
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                ELSE 0 
            END as absentValue,          
            main_attendance_sheet.minutes_lates_after_request as main_lates,
            CASE
            	WHEN main_attendance_sheet.`clock_in` != '' AND `main_attendance_sheet`.`clock_out` = '' THEN 0
                ELSE IF(main_attendance_sheet.leave_early_after_request = 0 ,0,main_attendance_sheet.leave_early_after_request)
            END as leave_mins
            
            FROM main_attendance_sheet
             "
        );
        DB::connection('mysql2')->statement(
            "CREATE OR REPLACE VIEW last_main_view
            AS
            SELECT *,
            CASE
          		WHEN main_attendance_sheet.minutes_lates_after_request >= main_attendance_sheet.daily_late_minutes AND main_attendance_sheet.absent_after_holidays = '' THEN main_attendance_sheet.day_absent_value
            
           		WHEN main_attendance_sheet.no_attend = 0 AND main_attendance_sheet.no_leave = 1 THEN main_attendance_sheet.noLeave
           
                WHEN main_attendance_sheet.week = 'Saturday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = ''  THEN main_attendance_sheet.saturday_value
                WHEN main_attendance_sheet.week = 'Saturday' AND main_attendance_sheet.absent_after_holidays = 'True' 
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Sunday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.sunday_value
                WHEN main_attendance_sheet.week = 'Sunday' AND main_attendance_sheet.absent_after_holidays = 'True' 
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Monday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.monday_value
                WHEN main_attendance_sheet.week = 'Monday' AND main_attendance_sheet.absent_after_holidays = 'True'
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Tuesday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.tuesday_value
                WHEN main_attendance_sheet.week = 'Tuesday' AND main_attendance_sheet.absent_after_holidays = 'True' 
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Wednesday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.wednesday_value
                WHEN main_attendance_sheet.week = 'Wednesday' AND main_attendance_sheet.absent_after_holidays = 'True'  
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Thursday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.thursday_value
                WHEN main_attendance_sheet.week = 'Thursday' AND main_attendance_sheet.absent_after_holidays = 'True'  
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                WHEN main_attendance_sheet.week = 'Friday' AND main_attendance_sheet.absent_after_holidays = 'True' AND main_attendance_sheet.vacation_type = '' THEN main_attendance_sheet.friday_value
                WHEN main_attendance_sheet.week = 'Friday' AND main_attendance_sheet.absent_after_holidays = 'True'  
                AND (main_attendance_sheet.vacation_type = 'Vacation without pay' OR main_attendance_sheet.vacation_type = 'Sick leave'  OR main_attendance_sheet.vacation_type = 'Start work' ) THEN 1
                
                ELSE 0 
            END as absentValue,          
            main_attendance_sheet.minutes_lates_after_request as main_lates,
            CASE
            	WHEN main_attendance_sheet.`clock_in` != '' AND `main_attendance_sheet`.`clock_out` = '' THEN 0
                ELSE IF(main_attendance_sheet.leave_early_after_request = 0 ,0,main_attendance_sheet.leave_early_after_request)
            END as leave_mins
            
            FROM main_attendance_sheet
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
        //
    }
}
