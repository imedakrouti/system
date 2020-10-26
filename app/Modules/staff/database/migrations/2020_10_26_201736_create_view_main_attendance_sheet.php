<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewMainAttendanceSheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW main_attendance_sheet
            AS
            SELECT            
            final_attendance_sheet.*,
            DAYNAME(`final_attendance_sheet`.`selected_date`) AS `week`,
            employee_holiday_dates.date_holiday,
            IF(vacation_period_view.approval2 = 'Accepted',vacation_period_view.vacation_type,'') AS vacation_type,
                    
            IF(
               (absent = 'True' AND employee_holiday_dates.date_holiday IS Not Null ) 				-- not absent
            OR (absent = '' AND date_holiday IS Null)
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Saturday' AND final_attendance_sheet.saturday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL                        
                    ))
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Sunday' AND final_attendance_sheet.sunday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL                        
                    ))
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Monday' AND final_attendance_sheet.monday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL                        
                    ))
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Tuesday' AND final_attendance_sheet.tuesday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL                        
                    ))
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Wednesday' AND final_attendance_sheet.wednesday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL                        
                    ))
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Thursday' AND final_attendance_sheet.thursday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL                        
                    ))
            OR (DAYNAME(`final_attendance_sheet`.`selected_date`) = 'Friday' AND final_attendance_sheet.friday IS NULL AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                     OR vacation_period_view.vacation_type IS NULL
                    ))
            -- remove absent when
            OR (
                absent = 'True' 
                AND 
                     vacation_period_view.date_vacation IS NOT Null             
                AND 
                    (
                     vacation_period_view.vacation_type = 'Regular vacation' 
                     OR vacation_period_view.vacation_type = 'Work errand'
                     OR vacation_period_view.vacation_type = 'Training'
                    )
                AND 
                    vacation_period_view.approval2 = 'Accepted'
               )
               OR (absent = '' AND final_attendance_sheet.clock_in != '')  
               ,'','True') 
             
            AS 'absent_after_holidays',		-- not absent          
            
            
            request_leave_types.date_leave,request_leave_types.time_leave,
            IF((final_attendance_sheet.selected_date = request_leave_types.date_leave) 
                AND (final_attendance_sheet.`clock_in` >= request_leave_types.time_leave) 
                AND (request_leave_types.target = 'lates')
                AND (request_leave_types.approval2 = 'Accepted')
            ,'',
            final_attendance_sheet.minutes) AS 'minutes_lates_after_request',
            
            IF((final_attendance_sheet.selected_date = request_leave_types.date_leave) 
                AND (final_attendance_sheet.`clock_out` >= request_leave_types.time_leave) 
                AND (request_leave_types.target = 'leaves')
                AND (request_leave_types.approval2 = 'Accepted')
            ,'',
            final_attendance_sheet.leave_min)
            AS 'leave_early_after_request'   
            FROM final_attendance_sheet
            -- officail holiday
            LEFT OUTER JOIN employee_holiday_dates ON final_attendance_sheet.attendance_id = employee_holiday_dates.attendance_id
            AND final_attendance_sheet.selected_date = employee_holiday_dates.date_holiday
            -- employee vacation
            LEFT OUTER JOIN vacation_period_view ON final_attendance_sheet.employee_id = vacation_period_view.employee_id
            AND final_attendance_sheet.selected_date = vacation_period_view.date_vacation
            -- leave requests
            LEFT OUTER JOIN request_leave_types ON final_attendance_sheet.employee_id = request_leave_types.employee_id
            AND final_attendance_sheet.selected_date = request_leave_types.date_leave
            AND (request_leave_types.approval2 = 'Accepted')
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
        Schema::dropIfExists('view_main_attendance_sheet');
    }
}
