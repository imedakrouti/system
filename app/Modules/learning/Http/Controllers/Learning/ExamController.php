<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Learning\Http\Requests\ExamRequest;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Question;
use Learning\Models\Settings\Subject;
use Learning\Models\Learning\Answer;
use Learning\Models\Learning\LessonUser;
use Learning\Models\Learning\UserAnswer;
use Learning\Models\Learning\UserExam;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Students\Student;
use DB;

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
    public function store(ExamRequest $request)
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
    public function update(ExamRequest $request, Exam $exam)
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

    public function previewExam($exam_id)
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

    // teacher account
    public function viewExams()
    {
        $title = trans('learning::local.exams');
        $data = Exam::orderBy('start_date')->where('admin_id', authInfo()->id)->get();
        if (request()->ajax()) {
            return $this->examDataTable($data);
        }
        return view(
            'learning::teacher.exams.view-exams',
            compact('title')
        );
    }

    private function examDataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name', function ($data) {
                return '<a href="' . route('teacher.show-exam', $data->id) . '"><span><strong>' . $data->exam_name . '</strong></span></a> </br>' .
                    '<span class="black small">' . $data->description . '</span>';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-warning btn-sm" href="' . route('teacher.edit-exam', $data->id) . '">
                    <i class=" la la-edit"></i>
                </a>';
                return $btn;
            })
            ->addColumn('show_questions', function ($data) {
                $btn = '<a class="btn btn-primary btn-sm" href="' . route('teacher.show-exam', $data->id) . '">
                            ' . trans('learning::local.show_questions') . '
                        </a>';
                return $btn;
            })
            ->addColumn('applicants', function ($data) {
                $applicants = '<div class="badge badge-pill badge-danger">' . $data->userExams->count() . '</div>';
                $btn = '<a class="btn btn-danger white btn-sm" href="' . route('teacher.applicants', $data->id) . '">
                         ' . trans('learning::local.applicants') . ' ' . $applicants . '
                    </a>';
                return $btn;
            })
            ->addColumn('start_date', function ($data) {
                return '<span class="blue">' . \Carbon\Carbon::parse($data->start_date)->format('M d Y') . '<br>
                ' . \Carbon\Carbon::parse($data->start_time)->format('H:i a') . '
                </span>';
            })
            ->addColumn('end_date', function ($data) {
                return '<span class="red">' . \Carbon\Carbon::parse($data->end_date)->format('M d Y') . ' <br>
                ' . \Carbon\Carbon::parse($data->end_time)->format('H:i a') . '
                </span>';
            })

            ->addColumn('check', function ($data) {
                $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                <span class="lbl"></span>
                            </label>';
                return $btnCheck;
            })
            ->rawColumns(['action', 'check', 'start_date', 'end_date', 'exam_name', 'show_questions', 'applicants'])
            ->make(true);
    }

    public function newExam()
    {
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $lessons = Lesson::with('subject')->where('admin_id', authInfo()->id)->orderBy('lesson_title')->get();
        $title = trans('learning::local.new_exam');
        return view(
            'learning::teacher.exams.new-exam',
            compact('title', 'lessons', 'divisions', 'grades')
        );
    }

    private function examAttributes()
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

    public function storeExam(ExamRequest $request)
    {
        DB::transaction(function () use ($request) {
            $this->exam =  $request->user()->exams()->firstOrCreate(request()->only($this->examAttributes()));
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
        return redirect()->route('teacher.show-exam', $this->exam->id);
    }

    public function showExam($exam_id)
    {
        $exam = Exam::with('subjects', 'classrooms')->where('admin_id', authInfo()->id)->where('id', $exam_id)->first();
        $questions = Question::with('answers', 'matchings')->where('exam_id', $exam_id)->orderBy('question_type')
            ->get();
        // $questions = $questions->shuffle();   

        $title = trans('learning::local.exams');
        $n = 1;
        $classes = Classroom::with('employees')->whereHas('employees', function ($q) {
            $q->where('employee_id', employee_id());
        })->get();
        // all classes related to teacher - get through playlist that related to teacher
        $arr_classes = [];
        foreach ($exam->classrooms as $class) {
            $arr_classes[] = $class->id;
        }
        return view(
            'learning::teacher.exams.show-exam',
            compact('title', 'exam', 'questions', 'n', 'classes', 'arr_classes')
        );
    }

    public function editExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
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
            'learning::teacher.exams.edit-exam',
            compact(
                'title',
                'exam',
                'lessons',
                'arr_lessons',
                'divisions',
                'grades',
                'arr_divisions',
                'arr_grades'
            )
        );
    }

    public function updateExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        DB::transaction(function () use ($exam) {
            $exam->update(request()->only($this->examAttributes()));

            DB::table('lesson_exam')->where('exam_id', $exam->id)->delete();
            if (request()->has('lessons')) {
                foreach (request('lessons') as $lesson_id) {
                    $exam->lessons()->attach($lesson_id);
                }
            }

            // DB::table('exam_division')->where('exam_id',$exam->id)->delete();                   
            // foreach (request('divisions') as $division_id) {
            //     $exam->divisions()->attach($division_id);                        
            // }

            // DB::table('exam_grade')->where('exam_id',$exam->id)->delete();

            // foreach (request('grades') as $grade_id) {
            //     $exam->grades()->attach($grade_id);                        
            // }          
        });
        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('teacher.view-exams');
    }

    private function questionAttributes()
    {
        return [
            'question_type',
            'question_text',
            'mark',
            'exam_id',
            'admin_id',
        ];
    }

    public function storeQuestion()
    {
        DB::transaction(function () {
            // check exist image
            if (request()->hasFile('file_name')) {

                $image_path = '';
                $this->file_name = uploadFileOrImage($image_path, request('file_name'), 'images/questions_attachments');

                $question =  request()->user()->questions()->firstOrCreate(request()->only($this->questionAttributes()) +
                    ['file_name' => $this->file_name]);
            } else {
                $question =  request()->user()->questions()->firstOrCreate(request()->only($this->questionAttributes()));
            }

            if (request('question_type') == 'multiple_choice' || request('question_type') == 'complete') {
                foreach (request('repeater-group') as $answer) {
                    request()->user()->answers()->create([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => $answer['answer_note'],
                        'right_answer'  => $answer['right_answer'],
                        'question_id'   => $question->id,
                    ]);
                }
            }

            if (request('question_type') == 'true_false') {
                for ($i = 0; $i < count(request('answer_text')); $i++) {
                    request()->user()->answers()->create([
                        'answer_text'   => request('answer_text')[$i],
                        'answer_note'   => request('answer_note')[$i],
                        'right_answer'  => request('right_answer')[$i],
                        'question_id'   => $question->id,
                    ]);
                }
            }

            if (request('question_type') == 'essay' || request('question_type') == 'paragraph') {
                request()->user()->answers()->create([
                    'answer_text'   => request('answer_text'),
                    'answer_note'   => '',
                    'right_answer'  => 'false',
                    'question_id'   => $question->id,
                ]);
            }

            if (request('question_type') == 'matching') {
                // matchings
                foreach (request('repeater-group-a') as $matching) {
                    request()->user()->matchings()->create([
                        'matching_item'     => $matching['matching_item'],
                        'matching_answer'   => $matching['matching_answer'],
                        'exam_id'           => request('exam_id'),
                        'question_id'       => $question->id,
                    ]);
                }
                // answers
                foreach (request('repeater-group-b') as $answer) {
                    request()->user()->answers()->create([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => '',
                        'right_answer'  => 'false',
                        'question_id'   => $question->id,
                    ]);
                }
            }
        });
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('teacher.show-exam', request('exam_id'));
    }

    public function editQuestion($question_id)
    {
        $question = Question::with('exam', 'answers', 'matchings')->where('id', $question_id)->first();
        $title = trans('learning::local.edit_question');
        return view(
            'learning::teacher.questions.edit-question',
            compact('title', 'question')
        );
    }

    public function updateQuestion($question_id)
    {
        $question = Question::findOrFail($question_id);
        if (request()->has('remove_image')) {
            $this->removeImage();
        }
        DB::transaction(function () use ($question) {

            if (request()->hasFile('file_name')) {
                $image_path = '';
                // remove old image
                if (!empty($question->file_name)) {
                    $image_path = public_path() . "/images/questions_attachments/" . $question->file_name;
                }
                // upload new image
                $this->file_name = uploadFileOrImage($image_path, request('file_name'), 'images/questions_attachments');

                $question->update([
                    'question_text' => request('question_text'),
                    'mark'          => request('mark'),
                    'file_name'     => $this->file_name
                ]);
            } else {
                $question->update([
                    'question_text' => request('question_text'),
                    'mark' => request('mark')
                ]);
            }

            if (
                request('question_type') == trans('learning::local.question_essay') ||
                request('question_type') == trans('learning::local.question_paragraph')
            ) {
                Answer::where('question_id', request('question_id'))->update(['answer_text' => request('answer_text')]);
            }

            // true or false
            if (request('question_type') == trans('learning::local.question_true_false')) {
                Answer::where('question_id', request('question_id'))->delete();

                for ($i = 0; $i < count(request('answer_text')); $i++) {
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => request('answer_text')[$i],
                        'answer_note'   => request('answer_note')[$i],
                        'right_answer'  => request('right_answer')[$i],
                        'question_id'   => $question->id,
                    ]);
                }
            }

            // multiple choice or complete
            if (
                request('question_type') == trans('learning::local.question_multiple_choice') ||
                request('question_type') == trans('learning::local.question_complete')
            ) {
                Answer::where('question_id', request('question_id'))->delete();
                foreach (request('repeater-group') as $answer) {
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => $answer['answer_note'],
                        'right_answer'  => $answer['right_answer'],
                        'question_id'   => $question->id,
                    ]);
                }
            }

            // matching
            if (request('question_type') == trans('learning::local.question_matching')) {
                // matchings
                Matching::where('question_id', request('question_id'))->delete();
                foreach (request('repeater-group-a') as $matching) {
                    request()->user()->matchings()->firstOrCreate([
                        'matching_item'     => $matching['matching_item'],
                        'matching_answer'   => $matching['matching_answer'],
                        'exam_id'           => request('exam_id'),
                        'question_id'       => $question->id,
                    ]);
                }
                // answers
                Answer::where('question_id', request('question_id'))->delete();
                foreach (request('repeater-group-b') as $answer) {
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => '',
                        'right_answer'  => 'false',
                        'question_id'   => $question->id,
                    ]);
                }
            }
        });

        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('teacher.show-exam', $question->exam_id);
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
            'learning::teacher.exams.preview',
            compact('title', 'exam', 'questions', 'n')
        );
    }

    public function setExamClasses()
    {
        $exam = Exam::find(request('exam_id'));

        DB::table('exam_classroom')->where('exam_id', $exam->id)->delete();
        foreach (request('classroom_id') as $classroom_id) {
            $exam->classrooms()->attach($classroom_id);
            request()->user()->posts()->firstOrCreate(
                [
                    'post_type'     => 'exam',
                    'url'           => $exam->id,
                    'post_text'     => $exam->exam_name,
                    'youtube_url'   => null,
                    'description'   => $exam->description,
                    'classroom_id'  => $classroom_id,
                ]
            );
        }

        toast(trans('learning::local.set_classes_successfully'), 'success');
        return redirect()->route('teacher.show-exam', request('exam_id'));
    }

    public function applicants($exam_id)
    {
        $title = trans('learning::local.applicants');
        $exam = Exam::findOrFail($exam_id);
        $data = Exam::with('userExams', 'userAnswers')->where('id', $exam_id)
            ->whereHas('userExams')
            ->get();

        if (request()->ajax()) {
            return $this->applicantsDataTable($data);
        }
        return view(
            'learning::teacher.exams.applicants',
            compact('title', 'exam_id', 'exam')
        );
    }

    private function applicantsDataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('check', function ($data) {
                $user_id = '';
                foreach ($data->userExams as $user_exam) {
                    $user_id = $user_exam->user_id;
                }
                $btnCheck = '<label class="pos-rel">
                            <input type="hidden" name="user_id" value="' . $user_id . '">
                            <input type="checkbox" class="ace" name="exam_id" value="' . $data->id . '" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
            })
            ->addColumn('student_name', function ($data) {
                $user = '';
                foreach ($data->userExams as $user_exam) {
                    $user =  $this->getFullStudentName($user_exam->user->studentUser);
                }
                return $user;
            })
            ->addColumn('student_image', function ($data) {
                $user_image = '';
                foreach ($data->userExams    as $user_exam) {
                    $user_image =  $this->studentImage($user_exam->user->studentUser);
                }
                return $user_image;
            })
            ->addColumn('exam_date', function ($data) {
                foreach ($data->userExams as $user_exam) {
                    return '<span class="blue">' . \Carbon\Carbon::parse($user_exam->created_at)->format('M d Y, D h:i a') . '</span>';
                }
            })
            ->addColumn('mark', function ($data) {
                return $data->userAnswers->sum('mark') . '/' . $data->total_mark;
            })
            ->addColumn('evaluation', function ($data) {
                return evaluation($data->total_mark, $data->userAnswers->sum('mark'));
            })
            ->addColumn('answers', function ($data) {
                $answers =  '<a class="btn btn-success btn-sm" href="' . route('teacher.show-answers', $data->id) . '">
                                ' . trans('student.answers') . '
                            </a>';
                $correct =  '<a class="btn btn-danger btn-sm" href="' . route('teacher.show-answers', $data->id) . '">
                    ' . trans('student.correct') . '
                </a>';
                return $data->auto_correct == 'no' &&  $data->userAnswers->sum('mark') == 0 ? $correct : $answers;
            })
            ->rawColumns(['check', 'student_name', 'exam_date', 'mark', 'evaluation', 'answers', 'student_image'])
            ->make(true);
    }

    private function getFullStudentName($data)
    {
        $classroom = Classroom::findOrFail(classroom_id($data));
        if (session('lang') == 'ar') {
            return $data->ar_student_name . ' ' . $data->father->ar_st_name . ' ' . $data->father->ar_nd_name . ' ' . $data->father->ar_rd_name . ' ' . $data->father->ar_th_name
                . ' <span class="blue"><strong></br>' . $classroom->ar_name_classroom . '</strong></span>';
        } else {
            return $data->en_student_name . ' ' . $data->father->en_st_name . ' ' . $data->father->en_nd_name . ' ' . $data->father->en_rd_name . ' ' . $data->father->en_th_name
                . ' <span class="blue"><strong></br>' . $classroom->en_name_classroom . '</strong></span>';
        }
    }

    private function studentImage($data)
    {
        $student_id = isset($data->id) ? $data->id : $data->student_id;
        $path_image = $data->gender == trans('student::local.male') ? 'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';
        return !empty($data->student_image) ?
            '<a href="' . route('students.show', $student_id) . '">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="' . asset('images/studentsImages/' . $data->student_image) . '" />
            </a>' :
            '<a href="' . route('students.show', $student_id) . '">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="' . asset($path_image) . '" />
            </a>';
    }

    public function showAnswers($exam_id)
    {
        $exam = Exam::with('userAnswers', 'userExams')->where('id', $exam_id)->first();

        $questions = Question::with('answers', 'matchings', 'userAnswers')->where('exam_id', $exam_id)->orderBy('question_type')
            ->get();

        $title = trans('learning::local.applicants');

        foreach ($exam->userExams as $user_exam) {
            $student_name =  $this->getFullStudentName($user_exam->user->studentUser);
        }

        $n = 1;
        return view(
            'learning::teacher.exams.show-answers',
            compact('title', 'exam', 'questions', 'n', 'student_name')
        );
    }

    public function correct()
    {
        DB::transaction(function () {
            for ($i = 0; $i < count(request('question_id')); $i++) {

                UserAnswer::where('question_id', request('question_id')[$i])->update([
                    'mark' => request('id')[$i]
                ]);
            }
            Exam::where('id', request('exam_id'))->update(['correct' => 'corrected']);
        });
        toast(trans('learning::local.correct_answer_done'), 'success');
        return redirect()->route('teacher.applicants', request('exam_id'));
    }

    public function destroyAnswers()
    {
        if (request()->ajax()) {
            DB::transaction(function () {
                $where = [
                    ['exam_id', request('exam_id')],
                    ['user_id', request('user_id')]
                ];
                UserExam::where($where)->delete();
                UserAnswer::where($where)->delete();
                Exam::where('id', request('exam_id'))->update(['correct' => null]);
            });
        }
        return response(['status' => true]);
    }

    public function getAnswer()
    {
        if (request()->ajax()) {
            $answer = Answer::where('question_id', request('question_id'))->first()->answer_text;
            return json_encode($answer);
        }
    }
    public function getReport()
    {
        if (request()->ajax()) {
            $report = UserExam::where('exam_id', request('exam_id'))->first()->report;
            return json_encode($report);
        }
    }

    public function examReport()
    {
        if (request()->ajax()) {
            UserExam::where('exam_id', request('exam_id'))->update(['report' => request('report')]);
        }
        return response(['status' => true]);
    }

    public function studentViews($lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        // students seen lesson
        $students_seen = LessonUser::where('lesson_id', $lesson_id)->orderBy('created_at', 'desc')->get();
        $users = [];
        foreach ($students_seen as $student) {
            $users[] = $student->user_id;
        }
        $seen = Student::whereIn('user_id', $users)->get();

        // students not seen lesson
        $classrooms = [];
        foreach ($lesson->playlist->classes as $classroom) {
            $classrooms[] = $classroom->id;
        }
        $not_seen = Student::with('rooms')->whereNotIn('user_id', $users)
            ->whereHas('rooms', function ($query) use ($classrooms) {
                $query->whereIn('classroom_id', $classrooms);
            })
            ->orderBy('ar_student_name')
            ->get();

        $title  = trans('learning::local.views');

        return view(
            'learning::teacher.lessons.student-views',
            compact('title', 'lesson', 'seen', 'not_seen')
        );
    }
}
