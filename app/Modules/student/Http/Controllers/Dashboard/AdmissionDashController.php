<?php

namespace Student\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Student\Models\Guardians\Guardian;
use Student\Models\Parents\Father;
use Student\Models\Students\Student;
use Carbon;
use DB;
use Student\Models\Settings\Division;


class AdmissionDashController extends Controller
{
    public function dashboard()
    {        
        $data['applicants'] = Student::whereHas('assessments',function($q){
            $q->where('acceptance','accepted');
        })
        ->where('student_type','applicant')
        ->count();

        $data['students'] = Student::whereHas('regStatus',function($q){
            $q->where('shown','show');
        })
        ->where('student_type','student')
        ->count();
        
        $data['parents'] = Father::count();
        $data['guardians'] = Guardian::count();
        
        $gradeCounts = $this->gradeCountQuery();
        $title = trans('admin.students_affairs');

        $students = Student::with('grade','division')
        ->where('student_type','applicant')
        ->whereDate('application_date', '=', Carbon\Carbon::today()->toDateString())
        ->limit(10)->orderBy('id','desc')
        ->get();

        return view('student::dashboard._admission',      
        compact('title','data','students','gradeCounts'));
    }

    private function gradeCountQuery()
    {  $students = DB::table('students')
        ->select('grades.ar_grade_name',DB::raw('count(students.id) as applicants'))
        ->join('grades','students.grade_id','=','grades.id')
        ->groupBy('students.grade_id')
        ->orderBy('grades.sort','asc')
        ->where('student_type' , 'applicant')
        ->get();
        if (count($students) > 0) {
            return $students;
        }
        return null;
    }

    public function applicantsByDivision()
    {
        $divisions = Division::sort()->get();
        $title = trans('student::local.statistic');
        return view('student::dashboard.applicants-divisions',
        compact('title','divisions'));
    }
    public function applicantsToday()
    {
        $students = Student::with('grade','division')
        ->where('student_type','applicant')
        ->whereDate('application_date', '=', Carbon\Carbon::today()->toDateString())
        ->orderBy('id','desc')
        ->paginate(20);
        $n = 1;
        $title = trans('student::local.today_applicants');
        return view('student::dashboard.applicants-today',
        compact('title','students','n'));
    }
    private function filterByDivision()
    {
        return DB::table('students')
        ->select('grades.ar_grade_name',DB::raw('count(students.id) as applicants'))
        ->join('grades','students.grade_id','=','grades.id')
        ->groupBy('students.grade_id')
        ->orderBy('grades.sort','asc')
        ->where([
            'student_type' => request('student_type'),
            'division_id' => request('division_id')
        ])
        ->get();
    }
    public function find()
    {
        if (request()->ajax()) {
            $data = $this->filterByDivision();            
            return datatables($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
 
}
