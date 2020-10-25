<?php

namespace Staff\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Staff\Models\Employees\Attendance;

class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Attendance([
            'attendance_id'      => $row['attendance_id'],
            'status_attendance'  => $row['status'],
            'time_attendance'    => $row['time'],
            'admin_id'           => authInfo()->id,

        ]);
    }
}
