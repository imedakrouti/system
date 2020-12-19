<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Learning\Models\Learning\Homework;
use Learning\Models\Learning\DeliverHomework;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Question;
use Student\Models\Settings\Classroom;
use DB;
use Learning\Http\Requests\HomeworkRequest;

class HomeworkController extends Controller
{
    private $file_name;
    private $homework;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function teacherHomeworks()
    {
        $classrooms = Classroom::with('employees')->whereHas('employees', function ($q) {
            $q->where('employee_id', employee_id());
        })->get();

        $lessons = Lesson::with('subject')->where('admin_id', authInfo()->id)->orderBy('lesson_title')->get();

        $data = Homework::with('deliverHomeworks')->where('admin_id', authInfo()->id)->orderBy('created_at', 'desc')->get();
        $title = trans('learning::local.class_work');
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view(
            'learning::teacher.homework.teacher-homeworks',
            compact('title', 'classrooms', 'lessons')
        );
    }
    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('due_date', function ($data) {
                return \Carbon\Carbon::parse($data->due_date)->format('M d Y, D');
            })
            ->addColumn('subject', function ($data) {
                return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-warning btn-sm" href="' . route('homeworks.edit', $data->id) . '">
                           <i class=" la la-edit"></i>
                       </a>';
                return $btn;
            })
            ->addColumn('show_homework', function ($data) {
                $btn = '';
                if (empty($data->instruction)) {
                    $btn = '<a class="btn btn-primary btn-sm" href="' . route('homework-question', $data->id) . '">
                                ' . trans('learning::local.show_homework') . '
                            </a>';
                } else {
                    $btn = '<a class="btn btn-purple btn-sm" href="' . route('homeworks.show', $data->id) . '">
                                ' . trans('learning::local.show_homework') . '
                            </a>';
                }
                return $btn;
            })
            ->addColumn('check', function ($data) {
                $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                        <span class="lbl"></span>
                                    </label>';
                return $btnCheck;
            })
            ->addColumn('applicants', function ($data) {
                $applicants = '<div class="badge badge-pill badge-danger">' . $data->deliverHomeworks->count() . '</div>';
                $btn = '<a class="btn btn-danger white btn-sm" href="' . route('teacher.homework-applicants', $data->id) . '">
                                 ' . trans('learning::local.applicants') . ' ' . $applicants . '
                            </a>';
                return $btn;
            })
            ->rawColumns(['action', 'check', 'subject', 'show_homework', 'due_date', 'applicants'])
            ->make(true);
    }
    public function questionPage($homework_id)
    {
        $homework = Homework::with('classrooms', 'lessons')->where('id', $homework_id)->first();

        $questions = Question::with('answers', 'matchings')
            ->where('homework_id', $homework_id)->orderBy('question_type')->get();
        $n = 1;
        $questions = $questions->shuffle();

        $title = trans('learning::local.add_questions');

        return view(
            'learning::teacher.homework.question-homework',
            compact('title', 'questions', 'homework', 'n')
        );
    }
    public function share()
    {
        if (request()->ajax()) {
            if (request()->has('homework_id')) {
                $homework = Homework::with('classrooms')->where('id', request('homework_id'))->first();
                foreach ($homework->classrooms as $classroom) {
                    request()->user()->posts()->create(
                        [
                            'post_type'     => 'assignment',
                            'post_text'     => $homework->title,
                            'url'           => $homework->id,
                            'description'   => null,
                            'youtube_url'   => null,
                            'classroom_id'  => $classroom->id
                        ]
                    );
                }
            }
        }
        return response(['status' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attributes()
    {
        return [
            'title',
            'due_date',
            'instruction',
            'subject_id',
            'admin_id',
            'total_mark',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeworkRequest $request)
    {
        DB::transaction(function () use ($request) {
            if ($request->hasFile('file_name')) {
                $file_path = '';
                $this->file_name = uploadFileOrImage($file_path, request('file_name'), 'images/homework_attachments');
            }

            $this->homework = request()->user()->homeworks()->firstOrCreate(request()->only($this->attributes()) + [
                'file_name' => $this->file_name,
            ]);
            DB::table('classroom_homework')->where('homework_id', $this->homework->id)->delete();
            foreach (request('classroom_id') as $classroom_id) {
                // add to homework_classroom table
                $this->homework->classrooms()->attach($classroom_id);

                // add post
                $this->addPost($classroom_id);
            }
            DB::table('lesson_homework')->where('homework_id', $this->homework->id)->delete();
            foreach (request('lessons') as $lesson_id) {
                $this->homework->lessons()->attach($lesson_id);
            }
        });

        if (request()->has('instruction')) {
            toast(trans('learning::local.add_published_successfully'), 'success');
            return redirect()->route('homeworks.show', $this->homework->id);
        }

        return redirect()->route('homework-question', $this->homework->id);
    }

    private function addPost($classroom_id)
    {
        if (request()->has('instruction')) {
            request()->user()->posts()->create(
                [
                    'post_type'     => 'assignment',
                    'post_text'     => empty($this->homework->instruction) ? '' : $this->homework->instruction,
                    'description'   => $this->homework->title,
                    'url'           => $this->homework->id,
                    'youtube_url'   => null,
                    'classroom_id'  => $classroom_id,
                ]
            );
        }
    }

    private function questionAttributes()
    {
        return [
            'question_type',
            'question_text',
            'mark',
            'homework_id',
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
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => $answer['answer_note'],
                        'right_answer'  => $answer['right_answer'],
                        'question_id'   => $question->id,
                    ]);
                }
            }

            if (request('question_type') == 'true_false') {
                for ($i = 0; $i < count(request('answer_text')); $i++) {
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => request('answer_text')[$i],
                        'answer_note'   => request('answer_note')[$i],
                        'right_answer'  => request('right_answer')[$i],
                        'question_id'   => $question->id,
                    ]);
                }
            }

            if (request('question_type') == 'matching') {
                // matchings
                foreach (request('repeater-group-a') as $matching) {
                    request()->user()->matchings()->firstOrCreate([
                        'matching_item'     => $matching['matching_item'],
                        'matching_answer'   => $matching['matching_answer'],
                        'exam_id'           => request('exam_id'),
                        'question_id'       => $question->id,
                    ]);
                }
                // answers
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
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('homework-question', request('homework_id'));
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = trans('learning::local.class_work');
        $classrooms = Classroom::with('employees')->whereHas('employees', function ($q) {
            $q->where('employee_id', employee_id());
        })->get();

        $lessons = Lesson::with('subject')->where('admin_id', authInfo()->id)->orderBy('lesson_title')->get();
        $homework = Homework::findOrFail($id);
        return view(
            'learning::teacher.homework.show',
            compact('title', 'homework', 'classrooms', 'lessons')
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $Homework)
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {
                    Homework::destroy($id);
                }
            }
        }
        return response(['status' => true]);
    }

    public function edit($id)
    {
        $arr_classes = [];
        $arr_lessons = [];

        $title = trans('learning::local.edit_homework');
        $lessons = Lesson::with('subject')->where('admin_id', authInfo()->id)->orderBy('lesson_title')->get();
        $homework = Homework::findOrFail($id);

        foreach (employeeClassrooms() as $class) {
            $arr_classes[] = $class->id;
        }

        // get all lessons related to this homework
        $homework_lessons = DB::table('lesson_homework')->where('homework_id', $id)->get();
        foreach ($homework_lessons as $lesson) {
            $arr_lessons[] = $lesson->lesson_id;
        }
        return view(
            'learning::teacher.homework.edit',
            compact('title', 'homework', 'lessons', 'arr_classes', 'arr_lessons')
        );
    }
    public function update(HomeworkRequest $request, $id)
    {
        DB::transaction(function () use ($id, $request) {
            $homework = Homework::findOrFail($id);
            if ($request->hasFile('file_name')) {
                $file_path = '';
                $this->file_name = uploadFileOrImage($file_path, request('file_name'), 'images/homework_attachments');
            }
            $homework->update($request->only($this->attributes()) + [
                'file_name' => $this->file_name,
            ]);
            $this->homework = $homework;

            foreach (request('classroom_id') as $classroom_id) {
                // add to homework_classroom table
                DB::table('classroom_homework')->where('classroom_id', $classroom_id)->delete();
                $homework->classrooms()->attach($classroom_id);

                // add post
                $this->addPost($classroom_id);
            }
            DB::table('lesson_homework')->where('homework_id', $homework->id)->delete();
            foreach (request('lessons') as $lesson_id) {
                $homework->lessons()->attach($lesson_id);
            }
        });

        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('teacher.homeworks');
    }

    public function homeworkApplicants($homework_id)
    {
        $title = trans('learning::local.applicants');
        $homework = Homework::findOrFail($homework_id);
        $data = Homework::with('deliverHomeworks')->where('id', $homework_id)
            ->whereHas('deliverHomeworks')
            ->get();

        if (request()->ajax()) {
            return $this->applicantsDataTable($data);
        }
        return view(
            'learning::teacher.homework.applicants',
            compact('title', 'homework')
        );
    }

    private function applicantsDataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('check', function ($data) {
                $user_id = '';
                foreach ($data->deliverHomeworks as $deliver_homework) {
                    $user_id = $deliver_homework->user_id;
                }
                $btnCheck = '<label class="pos-rel">
                            <input type="hidden" name="user_id" value="' . $user_id . '">
                            <input type="checkbox" class="ace" name="homework_id" value="' . $data->id . '" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
            })
            ->addColumn('student_name', function ($data) {
                $user = '';
                foreach ($data->deliverHomeworks as $deliver_homework) {
                    $user =  $this->getFullStudentName($deliver_homework->user->studentUser);
                }
                return $user;
            })
            ->addColumn('student_image', function ($data) {
                $user_image = '';
                foreach ($data->deliverHomeworks as $deliver_homework) {
                    $user_image =  $this->studentImage($deliver_homework->user->studentUser);
                }
                return $user_image;
            })
            ->addColumn('updated_at', function ($data) {
                foreach ($data->deliverHomeworks as $deliver_homework) {
                    return '<span class="blue">' . \Carbon\Carbon::parse($deliver_homework->updated_at)->format('M d Y, D h:i a') . '</span>';
                }
            })
            ->addColumn('mark', function ($data) {
                return empty($data->correct) ? '<span class="red"><strong>' . trans('learning::local.need_correct') . '</strong></span>' : $data->deliverHomeworks->sum('mark') .
                    '/<strong>' . $data->total_mark . '</strong>';
            })
            ->addColumn('answers', function ($data) {
                $answers =  '<a class="btn btn-success btn-sm" href="' . route('homework.show-answers', $data->id) . '">
                                ' . trans('student.answers') . '
                            </a>';
                $correct =  '<a class="btn btn-danger btn-sm" href="' . route('homework.show-answers', $data->id) . '">
                    ' . trans('student.correct') . '
                </a>';
                return $data->correct == '' &&  $data->deliverHomeworks->sum('mark') == 0 ? $correct : $answers;
            })
            ->rawColumns(['check', 'student_name', 'updated_at', 'mark', 'answers', 'student_image'])
            ->make(true);
    }

    private function getFullStudentName($data)
    {
        $classroom = Classroom::findOrFail(classroom_id($data));
        return $data->student_name .'<br> <span class="blue"><strong>' . $classroom->class_name . '</strong></span>';
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

    public function destroyAnswers()
    {
        if (request()->ajax()) {
            DB::transaction(function () {
                $where = [
                    ['homework_id', request('homework_id')],
                    ['user_id', request('user_id')]
                ];
                $user_answer = DeliverHomework::where($where)->first();

                if ($user_answer->file_name != '') {
                    $file_path = public_path() . "/images/homework_attachments/" . $user_answer->file_name;
                    removeFileOrImage($file_path); // remove file from directory                
                }
                $user_answer->delete();
            });
        }
        return response(['status' => true]);
    }

    public function showAnswers($homework_id)
    {
        $homework = Homework::with('deliverHomeworks', 'questions')->where('id', $homework_id)->first();

        $questions = Question::with('answers', 'matchings', 'userAnswers')
            ->where('homework_id', $homework_id)->orderBy('question_type')
            ->get();

        $title = trans('learning::local.applicants');

        foreach ($homework->deliverHomeworks as $deliver_homework) {
            $student_name =  $this->getFullStudentName($deliver_homework->user->studentUser);
        }

        $n = 1;
        return view(
            'learning::teacher.homework.show-answers',
            compact('title', 'homework', 'questions', 'n', 'student_name')
        );
    }

    public function setHomeworkMark()
    {
        DB::transaction(function () {
            $deliver_homework = DeliverHomework::where('homework_id', request('homework_id'))->first();
            $deliver_homework->update(['mark' => request('mark')]);

            Homework::where('id', request('homework_id'))->update(['correct' => 'corrected']);
        });
        toast(trans('learning::local.msg_set_homework_mark'), 'success');
        return redirect()->route('homework.show-answers', request('homework_id'));
    }
}
