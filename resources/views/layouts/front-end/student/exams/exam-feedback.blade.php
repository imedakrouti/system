@extends('layouts.front-end.student.index')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-content collapse show">
            <div class="card-body ">
                @if ($exam->auto_correct == 'yes')
                <h2 class="center blue"><strong>{{ trans('student.mark') }}</strong></h2>
                @if (evaluation($exam->total_mark, $exam->userAnswers->sum('mark')) == 'A+')
                    <h1 class="success center mb-1">{{ trans('student.congratulations') }}</h1>
                @endif
                  <table class="table table-border center">
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
                  <h4 class="mt-5 mb-1"><strong>{{ trans('student.equivalency') }}</strong></h4>
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

                  <div class="center">
                    <a class="btn btn-info" href="{{route('student.results')}}">{{ trans('student.back_to_results') }}</a>
                  </div>
              @else
                    <div class="center">
                        <img width="200" src="{{asset('images/website/checked.png')}}" alt="">
                        <h3 class="success  mb-2"><strong>{{ trans('student.exam_feedback_msg') }}</strong> </h3>                          
                        <a class="btn btn-info" href="{{route('student.exams')}}">{{ trans('student.back_to_exams') }}</a>
                    </div>   
              @endif
              
            </div>
          </div>
        </div>
    </div>
    @if ($exam->auto_correct == 'yes')
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
                                    <strong class="black">{{$n}} - {{$question->question_type}} <span class="red">{{ trans('learning::local.mark') }} 
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
                                                    <label class="pos-rel">
                                                        <input type="checkbox" class="ace" name="id[]" value="{{$question->id}}">
                                                        <span class="lbl"></span> {!!$question->question_text!!}                               
                                                    </label>  
                                                </h4>
                                            </div>                                                               
                                        @endif
                                    
                                    @if ($question->question_type != trans('learning::local.question_essay') && $question->question_type != trans('learning::local.question_matching'))
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
    @endif
</div>  
@endsection