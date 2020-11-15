<?php

namespace Learning\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Learning\Models\Settings\EmployeeSubject;
use Learning\Models\Settings\Subject;
use Staff\Models\Employees\Employee;

class EmployeeSubjectController extends Controller
{
    public function index()
    {
        $title = trans('learning::local.teacher_subject');
        $data = Employee::has('subjects')->work()->orderBy('attendance_id')->get();    
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::settings.teacher-subjects.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()   
                    ->addColumn('attendance_id',function($data){
                        return $data->attendance_id;
                    })                                                   
                    ->addColumn('employee_name',function($data){
                        return $this->getFullEmployeeName($data);
                    })
                    ->addColumn('employee_image',function($data){
                        return $this->employeeImage($data);
                    })
                    ->addColumn('subjects',function($data){                        
                        $subject_name = '';
                        foreach ($data->subjects as $subject) {                            
                            $subject_name .= '<div class="badge badge-primary">
                                                <span>'. $subject->ar_name.'</span>
                                                <i class="la la-check-circle-o font-medium-3"></i>
                                            </div> ' ;
                        }
                        return $subject_name;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','subjects','employee_name','employee_image','attendance_id'])
                    ->make(true);
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
    private function employeeImage($data)
    {
        $employee_id = isset($data->id) ? $data->id : $data->employee_id;   
        $image_path = $data->gender == trans('staff::local.male') ? 'images/website/male.png' : 'images/website/female.png';     
        return !empty($data->employee_image)?
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/employeesImages/'.$data->employee_image).'" />
            </a>':
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset($image_path).'" />
            </a>';
    }
    public function create()
    {
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $subjects = Subject::sort()->get();
        $title = trans('learning::local.add_teacher_subject');
        return view('learning::settings.teacher-subjects.create',
        compact('employees','subjects','title'));
    }
    public function store()
    {
        if (request()->has('employee_id')) {
            foreach (request('employee_id') as $employee_id) {
                request()->user()->teacherSubject()->firstOrCreate([
                    'employee_id' => $employee_id,
                    'subject_id'  => request('subject_id'),
                ]);
            }
            toast(trans('msg.stored_successfully'),'success');
        }
        return redirect()->route('teacher-subjects.index');
    }
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    EmployeeSubject::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
