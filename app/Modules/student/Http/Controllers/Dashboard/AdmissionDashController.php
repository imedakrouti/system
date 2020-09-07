<?php

namespace Student\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Student\Models\Guardians\Guardian;
use Student\Models\Parents\Father;
use Student\Models\Students\Student;

class AdmissionDashController extends Controller
{
    public function dashboard()
    {
        $data['applicants'] = Student::where('student_type','applicant')->count();
        $data['students'] = Student::where('student_type','student')->count();
        $data['parents'] = Father::count();
        $data['guardians'] = Guardian::count();
        return view('student::dashboard._admission',
        ['title'=>trans('admin.admissions'),'data'=>$data]);
    }
 
}
