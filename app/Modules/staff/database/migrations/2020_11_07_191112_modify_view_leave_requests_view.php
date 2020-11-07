<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyViewLeaveRequestsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->statement(
            "CREATE OR REPLACE VIEW leave_requests_view
             AS
             SELECT leave_permissions.*,employees.attendance_id,leave_types.target
             FROM leave_permissions
             INNER JOIN employees ON leave_permissions.employee_id = employees.id
             inner join leave_types on leave_permissions.leave_type_id = leave_types.id
             WHERE leave_permissions.approval1='Accepted' 
             AND leave_permissions.approval2 = 'Accepted'
             "
        ); 
        DB::connection('mysql2')->statement(
            "CREATE OR REPLACE VIEW leave_requests_view
             AS
             SELECT leave_permissions.*,employees.attendance_id,leave_types.target
             FROM leave_permissions
             INNER JOIN employees ON leave_permissions.employee_id = employees.id
             inner join leave_types on leave_permissions.leave_type_id = leave_types.id
             WHERE leave_permissions.approval1='Accepted' 
             AND leave_permissions.approval2 = 'Accepted'
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
