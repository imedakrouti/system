<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use DateInterval;
use DatePeriod;
use DateTime;
use Learning\Models\Learning\Absences;
use Student\Models\Students\Student;

class AbsencesController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // $data = 
        }
        $title = trans('learning::local.behaviour');
        return view(
            'learning::teacher.absences.index',
            compact('title')
        );
    }

    public function create()
    {
        // return date('l', strtotime(request('start_in')));

        $students = Student::with('father', 'classrooms')
            ->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', request('classroom_id'));
            })
            ->sort()->get();
        $title = trans('learning::local.attendance');
        $period = $this->absencesPeriod();
        return view(
            'learning::teacher.absences.create',
            compact('students', 'title','period')
        );
    }

    private function absencesPeriod()
    {
        $end = new DateTime(request('end_in') );
        $end = $end->modify( '+1 day' ); 

        $period = new DatePeriod(
            new DateTime(request('start_in')),
            new DateInterval('P1D'),
            $end
            
        );
        return $period;
    }

    public function store()
    {
        dd(request()->all());
    }
}
