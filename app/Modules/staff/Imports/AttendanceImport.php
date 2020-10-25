<?php

namespace Staff\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Staff\Models\Employees\Attendance;

class AttendanceImport implements ToModel, WithHeadingRow
{
    public $attendance_sheet_id;

    public function __construct($attendance_sheet)
    {
        return $this->attendance_sheet_id = $attendance_sheet->id;
    }
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
            'attendance_sheet_id'        => $this->attendance_sheet_id,            
            'admin_id'           => authInfo()->id,

        ]);
    }
}
