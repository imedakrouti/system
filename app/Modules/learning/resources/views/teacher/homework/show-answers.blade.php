@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
        .text-mark{
            width: 10%;
            text-align: center;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.25;
            color: #4E5154;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #BABFC7;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;            
        }
    </style>
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('teacher.homeworks')}}">{{ trans('learning::local.class_work') }}</a>
            </li>         
            <li class="breadcrumb-item"><a href="{{route('teacher.homework-applicants',$homework->id)}}">{{ trans('learning::local.applicants') }}</a>
            </li>     
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div>    
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    <h2><strong>{!!$student_name!!}</strong> </h2>
                    <div class="table-responsive">
                        <table class="table mt-2">
                            <thead>                            
                                <th>{{ trans('learning::local.deliver_date') }}</th>
                                <th>{{ trans('student.total_mark') }}</th>
                                <th>{{ trans('student.mark') }}</th>
                                <th>{{ trans('student.evaluation') }}</th>                            
                            </thead>
                            <tbody>
                                <tr>                                
                                    <td>
                                        @foreach ($homework->deliverHomeworks as $deliver_homework)                            
                                            {{\Carbon\Carbon::parse( $deliver_homework->updated_at)->format('M d Y, D h:i a ')}}
                                        @endforeach                                
                                    </td>
                                    <td>{{$homework->total_mark}}</td>
                                    <td>{{$homework->deliverHomeworks->sum('mark')}}</td>
                                    <td><strong>{{evaluation($homework->total_mark, $homework->deliverHomeworks->sum('mark'))}}</strong></td>                                
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="mt-2 mb-1"><strong>{{ trans('student.equivalency') }}</strong></h4>

                    <div class="table-responsive">
                        <table class="table table-border center">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- assignment --}}
@empty($homework->questions->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="red"><strong>{{$homework->title}}</strong></h3>
                    <p class="card-text" style="white-space: pre-line">{!!$homework->instruction!!}</p>
                    <form action="{{route('set-homework-mark')}}" method="post">
                        @csrf
                        <input type="hidden" name="homework_id" value="{{$homework->id}}">
                        <span class="red">{{ trans('learning::local.mark') }} {{$homework->mark}}</span> </strong>                        
                        @foreach ($homework->deliverHomeworks as $user_answer)
                            <div class="form-group">
                                <input type="number"  min="0"  step="0.5" max="{{$homework->total_mark}}" class="text-mark" 
                                name="mark" value="{{$user_answer->mark}}">                                                                                    
                                @if ($user_answer->file_name != '')
                                <div class="pull-right">                                  
                                    <a target="_blank" href="{{asset('images/homework_attachments/'.$user_answer->file_name)}}" class="btn btn-info"><i class="la la-download"></i> {{ trans('learning::local.attachments') }}</a>
                                </div>
                                @endif
                            </div>
                            <div class="form-group"> 
                                <textarea name="user_answer" class="form-control" cols="30" rows="10">{{$user_answer->user_answer}}</textarea>                                
                            </div>                        
                        @endforeach
                        
                        <div class="form-actions left">
                            <button type="submit" class="btn btn-success">
                                <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                              </button>
                            <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher.homework-applicants',$homework->id)}}';">
                            <i class="ft-x"></i> {{ trans('admin.cancel') }}
                          </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endempty

{{-- questions --}}
@if (count($homework->questions) > 0)
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
                <h2 class="center blue"><strong>{{ trans('student.the_answers') }}</strong></h2>
              <h4>{{ trans('learning::local.questions_count') }} : {{count($questions)}}</h4>
              <form id="formData" action="{{route('teacher.correct-answers')}}" method="POST">
                @csrf      
                <input type="hidden" name="exam_id" value="{{$exam->id}}">
                {{-- fetch questions --}}
                @foreach ($questions as $question)
                    <div class="bs-callout-info callout-border-left callout-square callout-bordered callout-transparent mt-1 p-1">
                        <strong class="black">{{$n}} - {{$question->question_type}} 
                            <span class="red">{{ trans('learning::local.mark') }} {{$question->mark}}</span> </strong>
                            {{-- manual correct answer --}}
                            @if ($question->question_type == trans('learning::local.question_essay') ||
                            $question->question_type == trans('learning::local.question_paragraph'))
                                @foreach ($question->userAnswers as $user_answer)
                                    @if ($question->id == $user_answer->question_id)
                                        <input type="number" min="0"  step="1" max="{{$question->mark}}" class="text-mark" name="id[]" value="{{$user_answer->mark}}">                                                                                    
                                    @endif
                                @endforeach
                            @endif
                            {{-- file name --}}
                            @isset($question->file_name)
                                <div class="form-group center">                                    
                                    <img class="mt-1" width="75%" src="{{asset('images/questions_attachments/'.$question->file_name)}}" alt="" >
                                </div>
                            @endisset
                            {{-- display question name --}}
                            @if ($question->question_type == trans('learning::local.question_matching'))
                                <div class="mb-1 mt-1">
                                    <h4 class="red">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" name="id[]" value="{{$question->id}}">
                                            <span class="lbl"></span> {{ trans('learning::local.matching_between_columns') }}                               
                                        </label>  
                                    </h4>
                                </div>  
                            @else
                                <div class="mb-1 mt-1">
                                    <h4 class="red">
                                        <strong>{!!$question->question_text!!} </strong>
                                    </h4>
                                </div>                                                               
                            @endif
                        
                            @if ($question->question_type != trans('learning::local.question_essay') && 
                            $question->question_type != trans('learning::local.question_paragraph') &&
                            $question->question_type != trans('learning::local.question_matching'))
                                @if ($question->question_type == trans('learning::local.question_complete'))
                                
                                    <h5 class="black">   
                                        <strong>{{ trans('learning::local.possible_answers') }} : </strong>
                                        @foreach ($question->answers as $answer)                        
                                            [ {{$answer->answer_text}} ] 	&nbsp;
                                        @endforeach 
                                        <div class="badge badge-success">
                                            <span>{{trans('learning::local.right_answer')}}</span>
                                            <i class="la la-check font-medium-3"></i>
                                        </div> 
                                    </h5>
                                    {{-- student answer --}}
                                    <h5 class="black">   
                                        <strong>{{ trans('student.your_answer') }} : </strong>
                                        @foreach ($exam->userAnswers as $user_answer)
                                            @if ($question->id == $user_answer->question_id )
                                                {{$user_answer->user_answer}} 
                                                @if ($user_answer->mark != 0)
                                                    <span class="success"><i class="la la-check"></i><strong>{{ trans('student.correct') }}</strong></span>
                                                @else
                                                    <span class="danger"><i class="la la-close"></i><strong>{{ trans('student.wrong') }}</strong></span>
                                                @endif
                                            @endif
                                        @endforeach  
                                    </h5>
                                    
                                @else
                                    @foreach ($question->answers->shuffle() as $answer)                        
                                        <h5 class="black">
                                            <label class="pos-rel">
                                                <input type="radio" class="ace" name="{{$question->id}}" value="{{$question->id}}">
                                                <span class="lbl"></span> {{$answer->answer_text}} 
                                                @if ($answer->right_answer == 'true')
                                                    <div class="badge badge-success">
                                                        <span>{{trans('learning::local.right_answer')}}</span>
                                                        <i class="la la-check font-medium-3"></i>
                                                    </div> 
                                                @endif
                                            </label>                                
                                        </h5>                                    
                                    @endforeach                                                            
                                    {{-- student answer --}}
                                    <h5 class="black">   
                                        <strong>{{ trans('student.your_answer') }} : </strong>
                                        @foreach ($exam->userAnswers as $user_answer)
                                            @if ($question->id == $user_answer->question_id )
                                                {{$user_answer->user_answer}} 
                                                @if ($user_answer->mark != 0)
                                                    <span class="success"><i class="la la-check"></i><strong>{{ trans('student.correct') }}</strong></span>
                                                @else
                                                    <span class="danger"><i class="la la-close"></i><strong>{{ trans('student.wrong') }}</strong></span>
                                                @endif
                                            @endif
                                        @endforeach  
                                    </h5>
                                @endif
                            @endif
                            
                            {{-- matching --}}
                            @if ($question->question_type == trans('learning::local.question_matching'))
                                    <div class="row">
                                    <div class="col-lg-9 col-md-12">
                                        <ol>
                                            @foreach ($question->matchings->shuffle() as $matching)
                                                <li>
                                                    <strong>{{$matching->matching_item}}</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @foreach ($question->answers as $answer)                            
                                                        <label class="pos-rel">
                                                            <input type="radio" class="ace" name="{{$matching->id}}" value="true">
                                                            <span class="lbl"></span> {{$answer->answer_text}}                               
                                                        </label>  
                                                        
                                                    @endforeach
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <div class="badge badge-success">
                                                        <span>{{trans('learning::local.right_answer')}}</span>
                                                        <i class="la la-check font-medium-3"></i>
                                                    </div>  {{$matching->matching_answer}}
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <ol type="I">
                                            @foreach ($question->answers->shuffle() as $answer)
                                                <li>{{$answer->answer_text}}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                    </div>

                            @endif
                            
                            {{-- essay or paragraph --}}
                            @if ($question->question_type == trans('learning::local.question_essay') ||
                                $question->question_type == trans('learning::local.question_paragraph'))
                                <div class="form-group mt-1">
                                    <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                    <input type="hidden" name="question_type[]" value="{{$question->question_type}}">
                                    @foreach ($question->userAnswers as $user_answer)
                                        @if ($question->id == $user_answer->question_id)
                                            <div class="form-group">
                                                <textarea style="font-size: 18px" class="form-control" cols="30" rows="10" >{{$user_answer->user_answer}}</textarea>                                        
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="form-group">                                        
                                        <a  onclick="showAnswer('{{$question->id}}')" class="btn btn-info white">{{ trans('learning::local.correct_answer') }}</a>
                                    </div>
                                </div>
                            @endif
                    </div>
                    @php
                        $n++;
                    @endphp
                @endforeach
                    <div class="form-group center mt-1">
                        <button type="submit" class="btn btn-success">{{ trans('learning::local.save_marks') }}</button>
                    </div>
              </form>                
          </div>
        </div>
      </div>
    </div>
</div>
@endif
@endsection