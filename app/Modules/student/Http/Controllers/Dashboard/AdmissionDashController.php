<?php

namespace Student\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Student\Models\Guardians\Guardian;
use Student\Models\Parents\Father;
use Student\Models\Students\Student;
use Carbon;
use DB;
use Student\Models\Parents\Mother;
use Student\Models\Settings\Division;


class AdmissionDashController extends Controller
{
    public function dashboard()
    {        
        $data['applicants'] = Student::whereHas('assessments',function($q){
            $q->where('acceptance','accepted');
        })
        ->where('student_type','applicant')
        ->where('year_id',currentYear())
        ->count();

        $data['students'] = Student::with('statements')->whereHas('statements',function($q){
            $q->where('year_id',currentYear());
        })
        ->count();
        
        $fathers = Father::join('students','fathers.id','=','students.father_id')
        ->join('students_statements','students.id','=','students_statements.student_id')
        ->where('students_statements.year_id',currentYear())->count();

        $mothers = Mother::join('students','mothers.id','=','students.mother_id')
        ->join('students_statements','students.id','=','students_statements.student_id')
        ->where('students_statements.year_id',currentYear())->count();

        $data['parents'] = $fathers + $mothers;

        $guardians = Guardian::join('students','guardians.id','=','students.guardian_id')
        ->join('students_statements','students.id','=','students_statements.student_id')
        ->where('students_statements.year_id',currentYear())->count();
        $data['guardians'] = $guardians;
        
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
    {     
        return DB::table('students')
        ->select('students.grade_id','grades.ar_grade_name','grades.en_grade_name','grades.sort',DB::raw('count(students.id) as applicants'))
        ->join('grades','students.grade_id','=','grades.id')
        ->groupBy('students.grade_id','grades.ar_grade_name','grades.en_grade_name','grades.sort')
        ->orderBy('grades.sort','asc')
        ->where('student_type' , 'applicant')
        ->get();
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
        ->select('grades.ar_grade_name','grades.ar_grade_name','grades.en_grade_name','grades.sort',DB::raw('count(students.id) as applicants'))
        ->join('grades','students.grade_id','=','grades.id')
        ->groupBy('students.grade_id','grades.ar_grade_name','grades.en_grade_name','grades.sort')
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
