<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewRequestLeaveTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW request_leave_types
            AS
            SELECT leave_types.*,leave_permissions.employee_id,leave_permissions.date_leave,
            leave_permissions.time_leave,leave_permissions.approval2
            FROM leave_permissions
            INNER JOIN leave_types
            ON leave_permissions.leave_type_id = leave_types.id"
            
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_request_leave_types');
    }
}
