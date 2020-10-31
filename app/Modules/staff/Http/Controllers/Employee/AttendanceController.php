<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Staff\Imports\AttendanceImport;
use Staff\Models\Employees\Attendance;
use Staff\Models\Employees\AttendanceSheet;
use Staff\Models\Employees\Employee;
use PDF;
use Staff\Models\Settings\HrReport;

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

    public function logs()
    {
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::attendances.logs',
        ['title'=>trans('staff::local.attendance'),'employees'=>$employees]);
    }
    public function sheetLogs()
    {        
        $attendance_id  = request('attendance_id');
        $from_date      = request('from_date');
        $to_date        = request('to_date');
        

        $data = DB::table('last_main_view')->orderBy('selected_date','asc')
            ->where('last_main_view.attendance_id', $attendance_id )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])
            ->get();            

        if (request()->ajax()) {
            return datatables($data)
            ->addIndexColumn()
            ->addColumn('week', function($data){
                $day = '';
                switch ($data->week) {
                    case 'Saturday':
                        $day = trans('staff::local.saturday');
                        break;
                    case 'Sunday':
                        $day = trans('staff::local.sunday');
                        break;
                    case 'Monday':
                        $day = trans('staff::local.monday');
                        break;
                    case 'Tuesday':
                        $day = trans('staff::local.tuesday');
                        break;
                    case 'Wednesday':
                        $day = trans('staff::local.wednesday');
                        break;
                    case 'Thursday':
                        $day = trans('staff::local.thursday');
                        break;
                    default:
                        $day = trans('staff::local.friday');
                        break;
                }

                return $day;
            })
            ->addColumn('vacation_type', function($data){
                $day = '';
                switch ($data->vacation_type) {
                    case 'Start work':
                        $day = trans('staff::local.startWork');
                        break;
                    case 'End work':
                        $day = trans('staff::local.end_work');
                        break;
                    case 'Sick leave':
                        $day = trans('staff::local.sick_leave');
                        break;
                    case 'Regular vacation':
                        $day = trans('staff::local.regular_vacation');
                        break;
                    case 'Vacation without pay':
                        $day = trans('staff::local.vacation_without_pay');
                        break;
                    case 'Work errand':
                        $day  = trans('staff::local.work_errand');
                        break;
                    case 'Training':
                        $day  = trans('staff::local.training');
                        break;
                    case 'Casual vacation':
                        $day  = trans('staff::local.casual_vacation');
                        break;
                    default:
                        $day = '';
                        break;
                }

                return $day;
            })
            ->addColumn('absent', function($data){
                $dayAbsent = '';
                switch ($data->absent_after_holidays) {
                    case 'True':
                        $dayAbsent ='<i class="la la-remove"><i>';                        
                        break;
                    default:
                        $dayAbsent ='';
                        break;
                }
                return $dayAbsent;
            })
            ->addColumn('no_attend', function($data){
                if($data->no_attend == 0 || ($data->no_attend == 1 && $data->no_leave == 1))
                {
                    return '';
                }else
                {
                    return '<i class="la la-check"><i>';
                }
            })
            ->addColumn('selected_date',function($data){
                $date = date("d-m-Y", strtotime($data->selected_date));
                return session('lang') == 'en'?$date:$data->selected_date;
            })
            ->addColumn('date_leave',function($data){
                if(!empty($data->date_leave))
                {
                    $date = date("d-m-Y", strtotime($data->date_leave));
                    return session('lang') == 'en'?$date:$data->date_leave;
                }else{
                    return '';
                }
            })
            
            ->addColumn('clock_in',function($data){
                if(!empty($data->clock_in))
                {
                    return date('h:i A', strtotime($data->clock_in));
                }
                return $data->clock_in;
            })
            ->addColumn('clock_out',function($data){
                if(!empty($data->clock_out))
                {
                    return date('h:i A', strtotime($data->clock_out));
                }
                return $data->clock_out;
            })
            ->addColumn('time_leave',function($data){
                if(!empty($data->time_leave))
                {
                    return date('h:i A', strtotime($data->time_leave));
                }
                return $data->time_leave;
            })
            ->addColumn('no_leave', function($data){
                if($data->no_leave == 0 || ($data->no_attend == 1 && $data->no_leave == 1))
                {
                    return '';
                }else
                {
                    return '<i class="la la-check"><i>';
                }
            })
            ->addColumn('date_holiday', function($data){
                if(empty($data->date_holiday))
                {
                    return '';
                }else
                {
                    return '<i class="la la-home"><i>';
                }
            })
            ->addColumn('absentValue', function($data){
                if($data->absentValue == 0)
                {
                    return '';
                }
                elseif($data->absentValue < 1)
                {
                    return $data->absentValue;
                }
                else{
                    return (int)$data->absentValue;
                }
            })
            ->addColumn('leave_mins', function($data){
                return ($data->leave_mins)==0?'':$data->leave_mins;
            })
            ->addColumn('main_lates',function($data){
                $main_lates = !empty($data->main_lates)?$data->main_lates:0;
                $minutes_lates_after_request = !empty($data->minutes_lates_after_request)?$data->minutes_lates_after_request:0;
                $lates =  $main_lates;
                return $lates == 0? '':$lates;
            })
            ->rawColumns(['absent','week','main_lates','no_attend','no_leave','leave_mins','absentValue','clock_in','vacation_type',
            'time_leave','clock_out','selected_date','date_holiday','date_leave'])
            ->make(true);
   		 }
    }

    public function summary()
    {
        $attendance_id  = request('attendance_id');
        $from_date      = request('from_date');
        $to_date        = request('to_date');

        $employee = Employee::with('timetable')->where('attendance_id',$attendance_id)->first();
        $data['employee_name'] = $this->getFullEmployeeName($employee);
        $data['working_data'] = $this->workingData($employee);
        $data['timetable_id'] = session('lang') == 'ar' ? $employee->timetable->ar_timetable : $employee->timetable->en_timetable;
        $data['hiring_date'] =  $employee->hiring_date;
        $data['leave_date'] =  empty($employee->leave_date)? trans('staff::local.work'):$employee->leave_date;
        
        $data['attend_days'] = DB::table('last_main_view')
            ->where('last_main_view.attendance_id', $attendance_id )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])  
            ->where('absent_after_holidays','!=','True')                              
            ->where('vacation_type','')                      
            ->count();
            
        $data['absent_days'] = DB::table('last_main_view')
            ->where('last_main_view.attendance_id', $attendance_id )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])  
            ->where('absent_after_holidays','True')                      
            ->count();
            
        $data['total_lates'] = DB::table('last_main_view')
                ->where('last_main_view.attendance_id', $attendance_id )
                ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])                  
                ->sum('main_lates') / 60;

        $data['vacation_days_count'] =DB::table('last_main_view')
            ->where('last_main_view.attendance_id', $attendance_id )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])  
            ->where('vacation_type','!=','')                      
            ->count();
        $data['leave_permissions_count'] = DB::table('last_main_view')
            ->where('last_main_view.attendance_id', $attendance_id )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])  
            ->whereNotNull('date_leave')                      
            ->count();

        return json_encode($data);
    }

    private function getFullEmployeeName($data)
    {
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->ar_st_name . ' ' . $data->ar_nd_name.
            ' ' . $data->ar_rd_name.' ' . $data->ar_th_name.'</a>';
        }else{
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->en_st_name . ' ' . $data->en_nd_name.
            ' ' . $data->th_rd_name.' ' . $data->th_th_name.'</a>';
        }
        return $employee_name;
    }

    private function workingData($data)
    {
        $sector = '';
        if (!empty($data->sector->ar_sector)) {
            $sector = session('lang') == 'ar' ?  '<span class="blue">'.$data->sector->ar_sector . '</span>': '<span class="blue">'.$data->sector->en_sector . '</span>';            
        }
        $department = '';
        if (!empty($data->department->ar_department)) {
            $department = session('lang') == 'ar' ?  '<span class="purple">'.$data->department->ar_department . '</span>': '<span class="blue">'.$data->department->en_department . '</span>';            
        }
        $section = '';
        if (!empty($data->section->ar_section)) {
            $section = session('lang') == 'ar' ?  '<span class="red">'.$data->section->ar_section . '</span>': '<span class="blue">'.$data->section->en_section . '</span>';            
        }
        return $sector . ' '. $department . '<br>' .  $section ;
    }

    public function attendanceSheetReport()
    {
        $attendance_id  = request('attendance_id');
        $from_date      = request('from_date');
        $to_date        = request('to_date');
        
        $employee = Employee::has('timetable')->where('attendance_id',request('attendance_id'))->first();
        if (empty($employee)) {
            toast(trans('staff::local.invalid_attendance_id'),'success');
            return back()->withInput();
        }
        
        $employee_name = session('lang') == 'ar' ? $employee->ar_st_name . ' ' . $employee->ar_nd_name.
        ' ' . $employee->ar_rd_name.' ' . $employee->ar_th_name:
        $employee->en_st_name . ' ' . $employee->en_nd_name.' ' . $employee->en_rd_name.' ' . $employee->en_th_name;            
      

        
        $working_data = $this->workingData($employee);        
        $hiring_date =  $employee->hiring_date;
        $leave_date =  empty($employee->leave_date)? trans('staff::local.work'):$employee->leave_date;
        
        $attend_days = DB::table('last_main_view')
            ->where('last_main_view.attendance_id', request('attendance_id') )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])  
            ->where('absent_after_holidays','!=','True')  
            ->where('vacation_type','')                                                     
            ->count();
            
        $absent_days = DB::table('last_main_view')
            ->where('last_main_view.attendance_id', request('attendance_id') )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])  
            ->where('absent_after_holidays','True')                      
            ->count();
            
        $total_lates = DB::table('last_main_view')
            ->where('last_main_view.attendance_id', request('attendance_id') )
            ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])                  
            ->sum('main_lates') / 60;    
        
        $logs = DB::table('last_main_view')->orderBy('selected_date','asc')
        ->where('last_main_view.attendance_id', request('attendance_id') )
        ->whereBetween('last_main_view.selected_date', [$from_date , $to_date])
        ->get();  

        $header = HrReport::first()->header;        
        
        $data = [         
            'title'                         => trans('staff::local.attendance_sheet'),                   
            'logo'                          => logo(),            
            'header'                        => $header, 
            'employee_name'                 => $employee_name,           
            'working_data'                  => strip_tags($working_data),           
            'hiring_date'                   => $hiring_date,           
            'leave_date'                    => $leave_date,           
            'attend_days'                   => $attend_days,           
            'absent_days'                   => $absent_days,           
            'total_lates'                   => $total_lates,           
            'logs'                          => $logs,           
                   
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 5,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 30,
            'margin_bottom'        => 8,
        ]; 

        $pdf = PDF::loadView('staff::attendances.reports.attendance-sheet', $data,[],$config);
        return $pdf->stream(trans('staff::local.attendance_sheet'));
    }
}
