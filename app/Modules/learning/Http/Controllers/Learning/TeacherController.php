<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Learning\Models\Learning\DeliverHomework;
use Student\Models\Settings\Classroom;
use Student\Models\Students\Student;

class TeacherController extends Controller
{
    // employee_id() : is helper function get employee id
    public function nameList($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        $title = trans('learning::local.name_list');
        $students = Student::with('father', 'classrooms')
            ->whereHas('classrooms', function ($q) use ($classroom_id) {
                $q->where('classroom_id', $classroom_id);
            })
            ->get();
        return view(
            'learning::teacher.classrooms.name-list',
            compact('title', 'students', 'classroom')
        );
    }

    public function studentData()
    {
        if (request()->ajax()) {
            $student = Student::with('nationalities', 'father', 'mother')->where('id', request('student_id'))
                ->firstOrFail();
            return view('learning::teacher.classrooms.ajax-views.student-data', compact('student'));
        }
    }

    public function homework()
    {
        if (request()->ajax()) {
            $homeworks = DeliverHomework::with('homework')
                ->where('user_id', request('user_id'))
                ->whereHas('homework')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            return view('learning::teacher.classrooms.ajax-views.homework', compact('homeworks'));
        }
    }
    
}
