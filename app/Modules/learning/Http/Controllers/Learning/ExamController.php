<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Learning\Models\Learning\Exam;
use Illuminate\Http\Request;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Question;
use Learning\Models\Settings\Subject;
use DB;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;

class ExamController extends Controller
{
    private $exam;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('learning::local.exams');
        $data = Exam::orderBy('start_date')->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view(
            'learning::exams.index',
            compact('title')
        );
    }
    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name', function ($data) {
                return '<a href="' . route('exams.show', $data->id) . '"><span><strong>' . $data->exam_name . '</strong></span></a> </br>' .
                    '<span class="black small">' . $data->description . '</span>';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-warning btn-sm" href="' . route('exams.edit', $data->id) . '">
                    <i class=" la la-edit"></i>
                </a>';
                return $btn;
            })
            ->addColumn('show_questions', function ($data) {
                $btn = '<a class="btn btn-primary" href="' . route('exams.show', $data->id) . '">
                    ' . trans('learning::local.show_questions') . '
                </a>';
                return $btn;
            })
            ->addColumn('start', function ($data) {
                return '<span class="blue">' . $data->start_date . '</span>' . ' - ' . $data->start_time;
            })
            ->addColumn('end', function ($data) {
                return '<span class="red">' . $data->end_date . '</span>' . ' - ' . $data->end_time;
            })
            ->addColumn('check', function ($data) {
                $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                <span class="lbl"></span>
                            </label>';
                return $btnCheck;
            })
            ->rawColumns(['action', 'check', 'start', 'end', 'exam_name', 'show_questions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $lessons = Lesson::with('subject')->orderBy('lesson_title')->get();
        $title = trans('learning::local.new_exam');
        return view(
            'learning::exams.create',
            compact('title', 'subjects', 'lessons', 'divisions', 'grades')
        );
    }

    private function attributes()
    {
        return [
            'exam_name',
            'start_date',
            'start_time',
            'end_date',
            'end_time',
            'duration',
            'total_mark',
            'no_question_per_page',
            'description',
            'subject_id',
            'auto_correct',
            'show_results',
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
        DB::transaction(function () use ($request) {
            $this->exam =  $request->user()->exams()->firstOrCreate(request()->only($this->attributes()));
            if (request()->has('lessons')) {
                DB::table('lesson_exam')->where('exam_id', $this->exam->id)->delete();

                foreach (request('lessons') as $lesson_id) {
                    $this->exam->lessons()->attach($lesson_id);
                }
            }
            DB::table('exam_division')->where('exam_id', $this->exam->id)->delete();

            foreach (request('divisions') as $division_id) {
                $this->exam->divisions()->attach($division_id);
            }

            DB::table('exam_grade')->where('exam_id', $this->exam->id)->delete();

            foreach (request('grades') as $grade_id) {
                $this->exam->grades()->attach($grade_id);
            }
        });
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('exams.show', $this->exam->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $exam = Exam::with('subjects')->where('id', $exam->id)->first();
        $questions = Question::with('answers', 'matchings')->where('exam_id', $exam->id)->orderBy('question_type')
            ->get();
        $questions = $questions->shuffle();

        $title = trans('learning::local.exams');
        $n = 1;
        return view(
            'learning::exams.show',
            compact('title', 'exam', 'questions', 'n')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $subjects = Subject::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $lessons = Lesson::with('subject')->orderBy('lesson_title')->get();
        $title = trans('learning::local.edit_exam');
        $arr_lessons = [];
        $arr_divisions = [];
        $arr_grades = [];

        foreach ($exam->lessons as $lesson) {
            $arr_lessons[] = $lesson->id;
        }
        foreach ($exam->divisions as $division) {
            $arr_divisions[] = $division->id;
        }
        foreach ($exam->grades as $grade) {
            $arr_grades[] = $grade->id;
        }

        return view(
            'learning::exams.edit',
            compact(
                'title',
                'exam',
                'subjects',
                'lessons',
                'arr_lessons',
                'divisions',
                'grades',
                'arr_divisions',
                'arr_grades'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        DB::transaction(function () use ($exam) {
            $exam->update(request()->only($this->attributes()));

            DB::table('lesson_exam')->where('exam_id', $exam->id)->delete();
            if (request()->has('lessons')) {
                foreach (request('lessons') as $lesson_id) {
                    $exam->lessons()->attach($lesson_id);
                }
            }

            DB::table('exam_division')->where('exam_id', $exam->id)->delete();
            foreach (request('divisions') as $division_id) {
                $exam->divisions()->attach($division_id);
            }

            DB::table('exam_grade')->where('exam_id', $exam->id)->delete();

            foreach (request('grades') as $grade_id) {
                $exam->grades()->attach($grade_id);
            }
        });
        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('exams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {
                    Exam::destroy($id);
                }
            }
        }
        return response(['status' => true]);
    }
    public function preview($exam_id)
    {
        $exam = Exam::with('subjects', 'divisions', 'grades')->where('id', $exam_id)->first();
        $questions = Question::with('answers', 'matchings')->where('exam_id', $exam->id)->orderBy('question_type')
            ->get();
        $questions = $questions->shuffle();

        $n = 1;
        $title = trans('learning::local.preview_exam');
        return view(
            'learning::exams.preview',
            compact('title', 'exam', 'questions', 'n')
        );
    }
}
