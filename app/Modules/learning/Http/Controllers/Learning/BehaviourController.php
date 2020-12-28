<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Learning\Models\Learning\Behaviour;
use Learning\Models\Learning\Month;
use Learning\Models\Settings\EmployeeSubject;
use Student\Models\Settings\Classroom;
use Student\Models\Students\Student;

class BehaviourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('father', 'classrooms', 'behaviours')
            ->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', request('classroom_id'));
            })
            ->sort()->get();

        $title = trans('learning::local.behaviour');
        $class_name = request('class_name');
        $classroom_id = request('classroom_id');
        $months = Month::whereHas('behaviours',function($q){
            $q->where('classroom_id', request('classroom_id'));
        })        
        ->get();
        return view(
            'learning::teacher.behaviour.index',
            compact('title', 'months', 'students', 'class_name', 'classroom_id')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = Month::whereDoesntHave('behaviours', function ($q) {
            // $q->whereIn('subject_id', employeeSubjects()->pluck('id')->toArray());
            $q->where('classroom_id', request('classroom_id'));
        })
            ->get();

        $title = trans('learning::local.add_behaviour');
        $students = Student::with('father', 'classrooms')
            ->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', request('classroom_id'));
            })
            ->sort()->get();

        $classroom_id = request('classroom_id');
        $class_name = request('class_name');

        return view(
            'learning::teacher.behaviour.create',
            compact('title', 'students', 'months', 'class_name', 'classroom_id')
        );
    }

    private function attributes()
    {
        return [
            'year_id',
            'subject_id',
            'classroom_id',
            'month_id',
            'admin_id',
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        for ($i = 0; $i < count(request('student_id')); $i++) {
            $behaviour = $request->user()->behaviours()->firstOrCreate($request->only($this->attributes()) +
                [
                    'student_id'    => request('student_id')[$i],
                    'behaviour_mark'    => request('behaviour_mark')[$i],
                ]);
            
            $classroom = Classroom::findOrFail($behaviour->classroom_id);
        }
        toast(trans('learning::local.saved_behaviours'), 'success');
        return redirect()->route(
            'behaviour.index',
            ['classroom_id' => $classroom->id, 'class_name' => $classroom->class_name]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Behaviour  $behaviour
     * @return \Illuminate\Http\Response
     */
    public function show(Behaviour $behaviour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Behaviour  $behaviour
     * @return \Illuminate\Http\Response
     */
    public function edit(Behaviour $behaviour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Behaviour  $behaviour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Behaviour $behaviour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Behaviour  $behaviour
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        dd(request()->all());
        // $where = [
        //     ['classroom_id', $behaviour->classroom_id],
        //     ['month_id', $behaviour->month_id],
        //     ['subject_id', $behaviour->subject_id],
        // ];
        // Behaviour::where($where)->delete();
        toast(trans('learning::local.deleted_behaviours'), 'success');
        return redirect()->route('behaviour.index');
    }
}
