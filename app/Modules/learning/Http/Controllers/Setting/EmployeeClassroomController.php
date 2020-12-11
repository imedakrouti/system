<?php

namespace Learning\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Learning\Models\Settings\EmployeeClassroom;
use Staff\Models\Employees\Employee;

use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;

class EmployeeClassroomController extends Controller
{
    public function index()
    {
        $title = trans('learning::local.teacher_classes');        
        $data = Employee::has('classrooms')->work()->orderBy('attendance_id')->get();  
        
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        
        return view('learning::settings.teacher-classes.index',
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
                    ->addColumn('classrooms',function($data){     
                        $class_name = '';
                        foreach ($data->classrooms as $classroom) {                            
                            $class = session('lang') =='ar' ? $classroom->ar_name_classroom:$classroom->en_name_classroom;                   
                            $class_name .= '<div class="badge badge-warning">
                                                <span>'. $class.'</span>
                                                <i class="la la-flag font-medium-3"></i>
                                            </div> ' ;
                        }
                        return $class_name;
                    })
                    ->addColumn('subjects',function($data){                        
                        $subject_name = '';
                        foreach ($data->subjects as $subject) {     
                            $sub = session('lang') == 'ar' ? $subject->ar_name : $subject->en_name;
                            $subject_name .= '<div class="badge badge-primary">
                                                <span>'. $sub.'</span>
                                                <i class="la la-book font-medium-3"></i>
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
                    ->rawColumns(['check','classrooms','employee_name','employee_image','attendance_id','subjects'])
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
        //$image_path = $data->gender == trans('staff::local.male') ? 'images/website/male.png' : 'images/website/female.png';
        $image_path = employee_default_image($data->gender);
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
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $title = trans('learning::local.add_teacher_classroom');
        return view('learning::settings.teacher-classes.create',
        compact('employees','divisions','grades','title'));
    }
    public function store()
    {
        if (request()->has('employee_id','classroom_id')) {
            foreach (request('employee_id') as $employee_id) {
                foreach (request('classroom_id') as $classroom_id) {
                    request()->user()->teacherClasses()->firstOrCreate([
                        'employee_id'   => $employee_id,
                        'classroom_id'  => $classroom_id,
                    ]);                    
                }
            }
            toast(trans('msg.stored_successfully'),'success');
        }
        return redirect()->route('teacher-classes.index');
    }
    public function destroy()
    {        
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $employee_id) {
                    EmployeeClassroom::where('employee_id',$employee_id)->delete();
                }
            }
        }
        return response(['status'=>true]);
    }
}
