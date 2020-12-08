@extends('layouts.front-end.student.index')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>      
    </div>      
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
         <div class="card">
            <div class="card-body">
                <h4>{{ trans('learning::local.questions_count') }} : {{count($questions)}}</h4>
                <form id="formData" action="{{route('homework.store-answers')}}" method="POST">
                      @csrf          
                      <input type="hidden" name="questions_count" value="{{count($questions)}}">                      
                      <input type="hidden" name="homework_id" value="{{$homework->id}}">
                      @foreach ($questions as $question)
                       
                       
                                  <div class="bs-callout-info callout-border-left callout-square callout-bordered callout-transparent mt-1 mb-1 p-1">
                                      <strong class="black">{{$n}} - {{$question->question_type}} |  <span class="blue">{{ trans('learning::local.mark') }} 
                                          {{$question->mark}}</span></strong>

                                          <div class="mb-1 mt-1">
                                                <h4 class="red">
                                                    {!!$question->question_text!!}                
        
                                                    @if ($question->question_type == trans('learning::local.question_complete'))
                                                    <div class="form-group mt-1">
                                                        <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                                        <input type="hidden" name="question_type[]" value="{{$question->question_type}}">
                                                        <input type="text" class="form-control" name="{{$question->id}}">
                                                    </div>
                                                @endif
                                                </h4>
                                            </div>  
                                      
                                          @if ($question->question_type != trans('learning::local.question_complete')) 
                                          <input type="hidden" name="question_id[]" value="{{$question->id}}">                                                                               
                                          <input type="hidden" name="question_type[]" value="{{$question->question_type}}">
                                              @foreach ($question->answers->shuffle() as $answer)                        
                                                  <h5 class="black">
                                                      <label class="pos-rel">
                                                          <input type="radio" class="ace" name="{{$question->id}}" value="{{$answer->answer_text}}">
                                                          <span class="lbl"></span> {{$answer->answer_text}} 
                                                  
                                                      </label>                                
                                                  </h5>
                                              @endforeach                                                            
                                          @endif
                                                                                   
                                  </div>
                          @php
                              $n++;
                          @endphp
                      @endforeach
                      <div class="form-actions left">
                        <button type="submit" class="btn btn-success">
                            <i class="la la-check-square-o"></i> {{ trans('student.send') }}
                          </button>
                        <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('student.homeworks')}}';">
                        <i class="ft-x"></i> {{ trans('admin.cancel') }}
                      </button>
                    </div>
  
                </form>
                  
            </div>
         </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5><strong>{{ trans('student.expire_date') }} : </strong>{{\Carbon\Carbon::parse( $homework->due_date)->format('M d Y, D  ')}}</h5>
                <h5><strong>{{ trans('student.subject') }} : </strong>
                    {{session("lang") == "ar" ? $homework->subject->ar_name : $homework->subject->en_name}}</h5>
                <h5><strong>{{ trans('student.lessons') }} : </strong>
                </h5>
                <ol>
                    @foreach ($homework->lessons as $lesson)
                        <li><a target="_blank" href="{{route('student.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id])}}">{{$lesson->lesson_title}}</a> </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>   

 
@endsection