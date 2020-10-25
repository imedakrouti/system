<?php

namespace Staff\Http\Controllers\Employee;


use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Staff\Imports\AttendanceImport;
use Staff\Models\Employees\Attendance;

class AttendanceController extends Controller
{
    public function importPage()
    {
        return view('staff::attendances.import',
        ['title'=>trans('staff::local.import_attendance')]);
    }

    public function importExcel()
    {
        DB::transaction(function () {
            // requst

            set_time_limit(0);
            Excel::import(new AttendanceImport,request()->file('import_file'));

            $last_date_in_attendance_before_import = date('Y-m-d',strtotime(DB::table('date_lists')->max('selected_date'). ' + 1 day'));

            // inserting into table
            if(!empty($arr)){
                Attendance::insert($arr);
            }

            $last_date_in_attendance_after_import = date('Y-m-d',strtotime(Attendance::max('time_attendance')));
            // insert dates into date list table
            /*
            created function selectDate -- maybe you need to check function import excel sheet
            */
            $date_list = DB::select(DB::raw($this->selectDate($last_date_in_attendance_before_import,$last_date_in_attendance_after_import)));

            $to_fill = [];
            foreach($date_list as $record) {
              $to_fill[] = (array)$record;
            }
            // dd($last_date_in_attendance_before_import);

            DB::table('date_lists')->insert($to_fill);

        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('attendance.import');
    }

    public function selectDate($last_date_in_attendance_before_import,$last_date_in_attendance_after_import)
    {
      return "select * from (select adddate('" . $last_date_in_attendance_before_import ."',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
        where selected_date between '" . $last_date_in_attendance_before_import ."' and '" . $last_date_in_attendance_after_import ."';";
    }
}
