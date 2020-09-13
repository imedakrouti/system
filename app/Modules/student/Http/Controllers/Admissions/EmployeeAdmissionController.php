<?php
namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Student\Models\Students\Student;
use PDF;

class EmployeeAdmissionController extends Controller 
{
    public function bonus()
    {
        $title = trans('student::local.employee_admission');
        $admins = Admin::active()->has('employees')->get();        
        return view('student::admissions.employee-admission.bonus',
        compact('admins','title'));        
    }
    public function find()
    {
        if (request()->ajax()) {
            $data = Student::with('father','mother','division','grade')
            ->where('employee_id',request('adminId'))
            ->whereBetween('application_date',[request('fromDate'),request('toDate')])
            ->orderBy('application_date','asc')
            ->get();

            return datatables($data)
            ->addIndexColumn()
            ->addColumn('studentName',function($data){
                return $this->getFullStudentName($data);                                         
            })
            ->addColumn('motherName',function($data){
                return '<a href="'.route('mother.show',$data->mother->id).'">'.$data->mother->full_name.'</a>';                                       
            })
            ->addColumn('studentImage',function($data){
                return $this->studentImage($data);                        
            })
            ->addColumn('registration_status',function($data){
                return session('lang') == 'ar' ? $data->regStatus->ar_name_status:
                $data->regStatus->en_name_status;
            })
            ->addColumn('student_type',function($data){
                return $data->student_type == trans('student::local.applicant') ? '<span class="red">'.$data->student_type.'</span>':$data->student_type;     
            })
            ->addColumn('grade',function($data){
                return session('lang') == 'ar' ? $data->grade->ar_grade_name:
                $data->grade->en_grade_name;
            })
            ->addColumn('division',function($data){
                return session('lang') == 'ar' ? $data->division->ar_division_name:
                $data->division->en_division_name;
            })
            ->addColumn('check', function($data){
                   $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->rawColumns(['check','studentName','registration_status','grade','student_type',
            'division','studentImage','motherName'])
            ->make(true);
            
        }
    }
    private function getFullStudentName($data)
    {        
        if (session('lang') == 'ar') {
            return '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }
    }
    private function studentImage($data)
    {
        return !empty($data->student_image)?
            '<a href="'.route('students.show',$data->id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('storage/student_image/'.$data->student_image).'" />
            </a>':
            '<a href="'.route('students.show',$data->id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('storage/student_image/stu.jpg').'" />
            </a>';
    }
    public function report()
    {
        $data['employeeName'] = Admin::findOrFail(request('adminId'))->name;
        
        $data['students'] = Student::with('father','mother','division','grade')
            ->where('employee_id',request('adminId'))
            ->whereBetween('application_date',[request('fromDate'),request('toDate')])
            ->orderBy('application_date','asc')
            ->get();            
        $data['count'] = Student::with('father','mother','division','grade')
            ->where('employee_id',request('adminId'))
            ->whereBetween('application_date',[request('fromDate'),request('toDate')])
            ->orderBy('application_date','asc')
            ->count();      
                 
        $data['title'] = 'Employee Open Admission';    
        $data['schoolName'] = session('lang') == 'ar'?settingHelper()->ar_school_name:settingHelper()->en_school_name;    
        $data['logo'] = public_path('storage/logo/'.settingHelper()->logo);    
        $data['fromDate'] = request('fromDate');
        $data['toDate'] = request('toDate');

        // dd(public_path('storage/icon/'.settingHelper()->icon));
        $filename = 'admissions.pdf';

        $pdf = PDF::loadView('student::admissions.employee-admission.report', $data);
        return $pdf->stream( $filename);
    }
}
