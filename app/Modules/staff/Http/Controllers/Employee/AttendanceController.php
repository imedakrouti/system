<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Staff\Imports\AttendanceImport;
use Staff\Models\Employees\Attendance;
use Staff\Models\Employees\AttendanceSheet;
use Staff\Models\Employees\Employee;

class AttendanceController extends Controller
{
    public function importPage()
    {
        if (request()->ajax()) {
            $data = AttendanceSheet::with('admin')->orderBy('created_at','desc')->get();
            return datatables($data)
                    ->addIndexColumn()  
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->addColumn('sheet_name',function($data){
                        return '<a href="'.route("attendances.sheet",$data->id).'">'.$data->sheet_name.'</a>';
                    })
                    ->addColumn('admin',function($data){
                        return $data->admin->username;
                    })
                    ->rawColumns(['check','admin','sheet_name'])
                    ->make(true);
        }
        return view('staff::attendances.import',
        ['title'=>trans('staff::local.import_attendance')]);
    }

    public function importExcel()
    {
        DB::transaction(function () {
            // request

            set_time_limit(0);
            $attendance_sheet = request()->user()->attendanceSheet()->create([
                'sheet_name'    => request('import_file')->getClientOriginalName()                
            ]);
            Excel::import(new AttendanceImport($attendance_sheet),request()->file('import_file'));



            $last_date_in_attendance_before_import = date('Y-m-d',strtotime(DB::table('date_lists')->max('selected_date'). ' + 1 day'));

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

            DB::table('date_lists')->insert($to_fill);

        });

        toast(trans('staff::local.attendance_import_successfully'),'success');
        return redirect()->route('attendances.import');
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
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    AttendanceSheet::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function attendanceSheet($attendance_sheet_id)
    {        
        if (request()->ajax()) {
            $data = Attendance::with('admin')->orderBy('attendances.id','asc')
            ->join('employees','attendances.attendance_id','=','employees.attendance_id')
            ->where('attendance_sheet_id',$attendance_sheet_id)
            ->get();            
            return datatables($data)
                    ->addIndexColumn()  
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->addColumn('admin',function($data){
                        return $data->admin->username;
                    })
                    ->addColumn('employee_name',function($data){
                        return $this->getEmployeeNameByAttendanceId($data->attendance_id);
                    })
                    ->rawColumns(['check','admin','employee_name'])
                    ->make(true);
        }
        $title = trans('staff::local.attendance_sheet_data');
        $sheet_name = AttendanceSheet::findOrFail($attendance_sheet_id)->sheet_name;
        return view('staff::attendances.uploaded-sheet',
        compact('title','sheet_name','attendance_sheet_id')
        );
    }

    private function getEmployeeNameByAttendanceId($attendance_id)
    {
        $employee = Employee::where('attendance_id',$attendance_id)->first();        
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a href="'.route('employees.show',$employee->id).'">' .$employee->ar_st_name . ' ' . $employee->ar_nd_name.
            ' ' . $employee->ar_rd_name.' ' . $employee->ar_th_name.'</a>';
        }else{
            $employee_name = '<a href="'.route('employees.show',$employee->id).'">' .$employee->en_st_name . ' ' . $employee->en_nd_name.
            ' ' . $employee->th_rd_name.' ' . $employee->th_th_name.'</a>';
        }
        return $employee_name;
    }
}
