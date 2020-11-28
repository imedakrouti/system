@extends('layouts.front-end.student.index')
@section('content')
<div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body center">
          @if ($exam->auto_correct == 'yes')
          @if (evaluation($exam->total_mark, $exam->userAnswers->sum('mark')) == 'A+')
            <h1 class="success center mb-1">{{ trans('student.congratulations') }}</h1>
          @endif
              <table class="table table-border">
                <thead>
                  <tr>
                    <th>{{ trans('student.total_questions') }}</th>
                    <th>{{ trans('student.right_answer') }}</th>
                    <th>{{ trans('student.total_mark') }}</th>
                    <th>{{ trans('student.mark') }}</th>
                    <th>{{ trans('student.evaluation') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{$exam->questions->count()}}</td>
                    <td>{{$exam->userAnswers->count()}}</td>
                    <td>{{$exam->total_mark}}</td>
                    <td>{{$exam->userAnswers->sum('mark')}}</td>
                    <td class="blue"><strong>{{evaluation($exam->total_mark, $exam->userAnswers->sum('mark'))}}</strong></td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-border">
                <thead>
                  <tr>
                    <th>{{ trans('student.evaluation') }}</th>
                    <th>A+</th>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ trans('student.percentage') }}</td>
                    <td>95% ~ 100%</td>
                    <td>85% ~ 94%</td>
                    <td>75% ~ 84%</td>
                    <td>65% ~ 74%</td>
                    <td>0 ~ 64%</td>
                  </tr>
                </tbody>
              </table>
          @else
              <img width="200" src="{{asset('images/website/checked.png')}}" alt="">
              <h3 class="success">{{ trans('student.exam_feedback_msg') }} </h3>       
          @endif
          <a class="btn btn-info" href="{{route('student.exams')}}">{{ trans('student.back_to_exams') }}</a>
        </div>
      </div>
    </div>
  </div>
@endsection