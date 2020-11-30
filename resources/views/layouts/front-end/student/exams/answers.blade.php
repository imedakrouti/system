@extends('layouts.front-end.student.index')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('student.results')}}">{{ trans('student.results') }}</a>
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
                    <h4><strong>{{ trans('student.exam_date') }} :</strong> 
                        @foreach ($exam->userExams as $user_exam)                            
                            {{\Carbon\Carbon::parse( $user_exam->created_at)->format('M d Y, D h:m a ')}}
                        @endforeach
                    </h4>
                    <h4><strong>{{ trans('student.exam_name') }} :</strong> {{$exam->exam_name}}</h4>
                    <h4><strong>{{ trans('student.total_mark') }} :</strong> {{$exam->total_mark}}</h4>
                    <h4><strong>{{ trans('student.mark') }} :</strong> {{$exam->userAnswers->sum('mark')}}</h4>
                    <h4><strong>{{ trans('student.evaluation') }} :</strong> {{evaluation($exam->total_mark, $exam->userAnswers->sum('mark'))}}</h4>
                    <h4><strong>{{ trans('student.right_answer') }} :</strong> 
                    @php
                        $right_answers = 0;
                        foreach ($exam->userAnswers as $answer) {
                            if ($answer->mark != 0) {
                                $right_answers ++;
                            }
                        }
                    @endphp 
                    {{$right_answers}}
                    </h4>
                    <h4><strong>{{ trans('student.wrong_answer') }} :</strong> 
                        @php
                            $wrong_answers = 0;
                            foreach ($exam->userAnswers as $answer) {
                                if ($answer->mark == 0) {
                                    $wrong_answers ++;
                                }
                            }
                        @endphp 
                        {{$wrong_answers}}
                        </h4>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
                <h2 class="center blue"><strong>{{ trans('student.the_answers') }}</strong></h2>
              <h4>{{ trans('learning::local.questions_count') }} : {{count($questions)}}</h4>
              <form id="formData" action="">
                @csrf                               
                @foreach ($questions as $question)
                    <div class="bs-callout-info callout-border-left callout-square callout-bordered callout-transparent mt-1 p-1">
                        <strong class="black">{{$n}} - {{$question->question_type}} <span class="blue">{{ trans('learning::local.mark') }} 
                            {{$question->mark}}</span> </strong>
                            @isset($question->file_name)
                                <div class="form-group center">                                    
                                    <img class="mt-1" width="75%" src="{{asset('images/questions_attachments/'.$question->file_name)}}" alt="" >
                                </div>
                            @endisset
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
                                        <strong>{!!$question->question_text!!}</strong>
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
                                        <label><strong>{{ trans('student.your_answer') }} </strong></label>
                                        <textarea style="font-size: 18px" class="form-control" cols="30" rows="10" >{{$user_answer->user_answer}}</textarea>                                        
                                    @endif
                                @endforeach
                            </div>
                        @endif                        
                    </div>
                    @php
                        $n++;
                    @endphp
                @endforeach

              </form>                
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
