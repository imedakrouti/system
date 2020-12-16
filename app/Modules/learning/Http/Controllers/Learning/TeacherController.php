<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Student\Models\Students\Student;

class TeacherController extends Controller
{
    // employee_id() : is helper function get employee id
    public function nameList($classroom_id)
    {
        $title = trans('learning::local.name_list');
        $students = Student::with('father', 'classrooms')
            ->whereHas('classrooms', function ($q) use ($classroom_id) {
                $q->where('classroom_id', $classroom_id);
            })
            ->get();
        return view(
            'learning::teacher.classrooms.name-list',
            compact('title', 'students')
        );
    }
}
