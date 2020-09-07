<?php
namespace Student\Http\Controllers\Age;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\FuncCall;

use Student\Models\Settings\Year;

class AgeCalculateController extends Controller
{
    public function calculateStudentAge()
    {
        if (request()->ajax()) {
            $dob    = request('dob');    
            $data = getStudentAge($dob);
            return response(['status'=>true,'data'=>$data]);
        }
        return view('student::age.calculate-age',['title'=>trans('student::local.calculate_student_age')]);
    }

}