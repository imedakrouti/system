<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewLeaveRequestsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW leave_requests_view
            AS
            SELECT leave_permissions.*,employees.attendance_id
            FROM leave_permissions
            INNER JOIN employees ON leave_permissions.employee_id = employees.id
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
        Schema::dropIfExists('view_leave_requests_view');
    }
}
