<?php

namespace App\Http\Controllers\ParentStudent\Student;

use App\Http\Controllers\Controller;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Answer;
use Learning\Models\Learning\Question;
use Learning\Models\Learning\UserAnswer;
use Learning\Models\Learning\UserExam;
use Carbon\Carbon;
use DB;

class ExamController extends Controller
{
    public function upcomingExams()
    {
        $title = trans('student.upcoming_exams');
        $data = Exam::with('lessons', 'classrooms')
            ->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', classroom_id());
            })
            ->where('start_date', '>', date_format(Carbon::now(), "Y-m-d"))
            // ->where('start_time','>',date_format(Carbon::now(),"H:i"))
            ->orderBy('start_date')->get();

        if (request()->ajax()) {
            return $this->dataTableUpComingExams($data);
        }

        return view(
            'layouts.front-end.student.exams.upcoming-exam',
            compact('title')
        );
    }

    private function dataTableUpComingExams($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name', function ($data) {
                return '<span><strong>' . $data->exam_name . '</strong></span> </br>' .
                    '<span class="black small">' . $data->description . '</span>';
            })
            ->addColumn('start', function ($data) {
                return '<span class="blue">' . Carbon::parse($data->start_date)->format('M d Y') . '</span>';
            })
            ->addColumn('end', function ($data) {
                return '<span class="red">' . Carbon::parse($data->end_date)->format('M d Y') . '</span>';
            })
            ->addColumn('lessons', function ($data) {
                foreach ($data->lessons as $lesson) {
                    return '<div class="mb-1 badge badge-danger">
                    <i class="la la-book font-medium-3"></i>
                    <span><a target="_blank" href="' . route('student.view-lesson', ['id' => $lesson->id, 'playlist_id' => $lesson->playlist_id]) . '">' . $lesson->lesson_title . '</a></span>
                </div>';
                }
            })
            ->addColumn('subject', function ($data) {
                $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
                return '<span class="purple">' . $subject . '</span>';
            })

            ->rawColumns(['start', 'end', 'exam_name', 'subject', 'lessons'])
            ->make(true);
    }

    public function exams()
    {
        $title = trans('student.available_exams');
        $data = Exam::with('lessons', 'classrooms')
            ->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', classroom_id());
            })
            ->whereHas('questions', function ($q) {
            })
            ->whereDoesntHave('userExams')
            ->where('start_date', '<=', date_format(Carbon::now(), "Y-m-d"))
            ->where('start_time', '<', date_format(Carbon::now(), "H:i"))
            ->orderBy('start_date')->get();

        if (request()->ajax()) {
            return $this->dataTableExams($data);
        }

        return view(
            'layouts.front-end.student.exams.exams',
            compact('title')
        );
    }

    private function dataTableExams($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name', function ($data) {
                return '<span><strong>' . $data->exam_name . '</strong></span> </br>' .
                    '<span class="black small">' . $data->description . '</span>';
            })
            ->addColumn('start', function ($data) {
                return '<span class="blue">' . Carbon::parse($data->start_date)->format('M d Y') . '<br>
            ' . Carbon::parse($data->start_time)->format('H:i a') . '
            </span>';
            })
            ->addColumn('end', function ($data) {
                return '<span class="red">' . Carbon::parse($data->end_date)->format('M d Y') . ' <br>
            ' . Carbon::parse($data->end_time)->format('H:i a') . '
            </span>';
            })
            ->addColumn('subject', function ($data) {
                $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
                return '<span class="purple">' . $subject . '</span>';
            })
            ->addColumn('mark', function ($data) {
                return $data->userAnswers->sum('mark') == 0 ? '-' : $data->userAnswers->sum('mark');
            })
            ->addColumn('answers', function ($data) {
                return '<span class="red">' . $data->userAnswers->count() . '/' . $data->questions->count() . '</span>';
            })
            ->addColumn('start_exam', function ($data) {

                $time = new Carbon($data->start_time);
                $time_end = new Carbon($data->start_end);
                $btn = '';

                // hidden before date & time
                if ($data->start_date >= date_format(Carbon::now(), "Y-m-d")) {
                    $btn = '<span class="blue"><strong>' . trans('learning::local.not_yet') . '</strong></span>';
                }

                // today
                if (
                    $data->start_date <= date_format(Carbon::now(), "Y-m-d") &&
                    date_format($time->subMinutes(1), "H:i") < date_format(Carbon::now(), "H:i")
                ) {
                    $btn = '<a class="btn btn-success btn-sm" href="' . route('student.pre-start-exam', $data->id) . '">
                        ' . trans('student.start_exam') . '
                    </a>';
                }
                if ($data->start_date < date_format(Carbon::now(), "Y-m-d")) {
                    $btn = '<span class="red"><strong>' . trans('learning::local.finished') . '</strong></span>';
                }

                // hidden after date & time

                if (
                    $data->start_end == date_format(Carbon::now(), "Y-m-d") &&
                    date_format($time_end->subMinutes(1), "H:i") < date_format(Carbon::now(), "H:i")
                ) {
                    $btn = '<span class="red"><strong>' . trans('learning::local.finished') . '</strong></span>';
                }

                return $btn;
            })
            ->rawColumns(['start', 'end', 'exam_name', 'subject', 'mark', 'answers', 'start_exam'])
            ->make(true);
    }

    public function preStartExam($exam_id)
    {
        $count = UserExam::where('exam_id', $exam_id)->where('user_id', userAuthInfo()->id)->count();
        if ($count > 0) {
            return view('layouts.front-end.student.exams.finished_exam');
        }
        $exam = Exam::with('subjects', 'divisions', 'grades')->where('id', $exam_id)->first();
        return view(
            'layouts.front-end.student.exams.pre-start-exam',
            compact('exam')
        );
    }

    public function startExam($exam_id)
    {
        $count = UserExam::where('exam_id', $exam_id)->where('user_id', userAuthInfo()->id)->count();
        if ($count > 0) {
            return view('layouts.front-end.student.exams.finished_exam');
        }
        $exam = Exam::with('subjects', 'divisions', 'grades')->where('id', $exam_id)->first();
        // attend exam
        UserExam::create(['exam_id' => $exam_id, 'user_id' => userAuthInfo()->id]);

        $questions = Question::with('answers', 'matchings')->where('exam_id', $exam->id)->orderBy('question_type')
            ->get();

        $questions = $questions->shuffle();

        $n = 1;

        return view(
            'layouts.front-end.student.exams.start-exam',
            compact('exam', 'questions', 'n')
        );
    }

    public function submitExam()
    {
        DB::transaction(function () {
            $questions_count = request('questions_count');
            $this->resetExam();

            request()->user()->userExam()->firstOrCreate(['exam_id' => request('exam_id')]);

            for ($i = 0; $i < $questions_count; $i++) {
                request()->user()->userAnswers()->firstOrCreate([
                    'question_id'   => request('question_id')[$i],
                    'user_answer'   => request(request('question_id')[$i]),
                    'exam_id'       => request('exam_id'),
                ]);
            }
            $this->autoCorrectExam(request('exam_id'));
            if (request('auto_correct') == 'yes') {
                Exam::where('id', request('exam_id'))->update(['correct' => 'corrected']);
            }
        });
        return redirect()->route('student.feedback-exam', request('exam_id'));
    }

    private function resetExam()
    {
        UserExam::where('exam_id', request('exam_id'))->delete();
        UserAnswer::where('exam_id', request('exam_id'))->delete();
    }

    private function autoCorrectExam($exam_id)
    {
        DB::transaction(function () use ($exam_id) {
            $user_answers = UserAnswer::where('exam_id', $exam_id)->get();
            foreach ($user_answers as $ans) {
                $total_mark = Question::findOrFail($ans->question_id)->mark;

                $correct_answer = Answer::where('question_id', $ans->question_id)->where('right_answer', 'true')->get();
                foreach ($correct_answer as $answer) {
                    if ($ans->user_answer == $answer->answer_text) {
                        UserAnswer::where('question_id', $ans->question_id)
                            ->update(['mark' => $total_mark]);
                    }
                }
            }
        });
    }

    public function examFeedback($exam_id)
    {
        $exam = Exam::with('questions', 'userAnswers')->where('id', $exam_id)->first();
        $questions = Question::with('answers', 'matchings')->where('exam_id', $exam_id)->orderBy('question_type')
            ->get();
        $n = 1;
        return view(
            'layouts.front-end.student.exams.exam-feedback',
            compact('exam', 'questions', 'n')
        );
    }

    public function results()
    {
        $title = trans('student.results');
        $data = Exam::with('questions', 'classrooms', 'userAnswers', 'userExams')
            ->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', classroom_id());
            })
            ->whereHas('questions', function ($q) {
            })
            ->whereHas('userExams', function ($q) {
            })
            ->orderBy('start_date')
            ->where('show_results', 'yes')
            ->get();

        if (request()->ajax()) {
            return $this->dataTableResults($data);
        }

        return view(
            'layouts.front-end.student.exams.results',
            compact('title')
        );
    }

    private function dataTableResults($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name', function ($data) {
                return '<span><strong>' . $data->exam_name . '</strong></span> </br>' .
                    '<span class="black small">' . $data->description . '</span>';
            })
            ->addColumn('date_exam', function ($data) {

                foreach ($data->userExams as $user_exam) {
                    return '<span class="blue">' . Carbon::parse($user_exam->created_at)->format('M d Y, D') . '</span>';
                }
            })
            ->addColumn('subject', function ($data) {
                $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
                return '<span class="purple">' . $subject . '</span>';
            })

            ->addColumn('mark', function ($data) {
                return $data->userAnswers->sum('mark');
            })
            ->addColumn('answers', function ($data) {
                $right_answers = 0;
                foreach ($data->userAnswers as $answer) {
                    if ($answer->mark != 0) {
                        $right_answers++;
                    }
                }
                return '<span class="red">' . $right_answers . '/' . $data->questions->count() . '</span>';
            })
            ->addColumn('show_answers', function ($data) {
                return '<a class="btn btn-primary btn-sm" href="' . route('student.answers', $data->id) . '">
                ' . trans('student.answers') . '
            </a>';
            })
            ->addColumn('report', function ($data) {
                foreach ($data->userExams as $user_exam) {
                    return empty($user_exam->report) ? '' : '<a class="btn btn-info btn-sm" onclick="getReport(' . $user_exam->exam_id . ')" href="#">
                    ' . trans('student.report') . '
                </a>';
                }
            })
            ->rawColumns(['date_exam', 'exam_name', 'subject', 'mark', 'answers', 'show_answers', 'report'])
            ->make(true);
    }

    public function answers($exam_id)
    {
        $exam = Exam::with('userAnswers', 'userExams')->where('id', $exam_id)->first();

        $questions = Question::with('answers', 'matchings')->where('exam_id', $exam_id)->orderBy('question_type')
            ->get();

        $title = trans('student.answers');
        $n = 1;
        return view(
            'layouts.front-end.student.exams.answers',
            compact('title', 'exam', 'questions', 'n')
        );
    }

    public function getReportContent()
    {
        if (request()->ajax()) {
            $report = UserExam::where('exam_id', request('exam_id'))->first()->report;
            return json_encode($report);
        }
    }

    
}
