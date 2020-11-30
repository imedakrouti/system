@extends('layouts.front-end.student.index')
@section('content')

<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="red center"><strong>{{$exam->exam_name}}</strong></h1>                        
                    <h4 class="black center"><strong>{{ trans('learning::local.duration') }}
                        <span class="blue"> {{$exam->duration}}</span>
                        {{ trans('learning::local.minute') }}</strong></h4>
                        <h1 class="center blue" style="font-size: 60px"><span id="time">00:00</span> minutes</h1>             
                        <h1 class="center danger" style="font-size: 20px">
                            <strong>{{ trans('student.exam_auto_submit') }}</strong>
                        </h1>             
                </div>           
              </div>
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
              <h4>{{ trans('learning::local.questions_count') }} : {{count($questions)}}</h4>
              <form id="formData" action="{{route('student.submit-exam')}}" method="POST">
                @csrf          
                <input type="hidden" name="questions_count" value="{{count($questions)}}">
                <input type="hidden" name="auto_correct" value="{{$exam->auto_correct}}">
                @foreach ($questions as $question)
                <input type="hidden" name="exam_id" value="{{$question->exam_id}}">
                    <div class="bs-callout-info callout-border-left callout-square callout-bordered callout-transparent mt-1 mb-1 p-1">
                        <strong class="black">{{$n}} - {{$question->question_type}} |  <span class="blue">{{ trans('learning::local.mark') }} 
                            {{$question->mark}}</span></strong>
                            @isset($question->file_name)
                                <div class="form-group center">                                    
                                    <img class="mt-1" width="75%" src="{{asset('images/questions_attachments/'.$question->file_name)}}" alt="" >
                                </div>
                            @endisset
                            @if ($question->question_type == trans('learning::local.question_matching'))
                                <div class="mb-1 mt-1">
                                    <h4 class="red">
                                        {{ trans('learning::local.matching_between_columns') }}      
                                    </h4>
                                </div>  
                            @else
                                <div class="mb-1 mt-1">
                                    <h4 class="red">
                                        {!!$question->question_text!!} 
                                        @if ($question->question_type == trans('learning::local.question_essay') ||
                                            $question->question_type == trans('learning::local.question_paragraph'))
                                            <div class="form-group mt-1">
                                                <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                                <input type="hidden" name="question_type[]" value="{{$question->question_type}}">
                                                <textarea name="{{$question->id}}" class="form-control" cols="30" rows="10" ></textarea>
                                            </div>
                                        @endif

                                        @if ($question->question_type == trans('learning::local.question_complete'))
                                        <div class="form-group mt-1">
                                            <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                            <input type="hidden" name="question_type[]" value="{{$question->question_type}}">
                                            <input type="text" class="form-control" name="{{$question->id}}">
                                        </div>
                                    @endif
                                    </h4>
                                </div>                                                               
                            @endif
                        
                        @if ($question->question_type != trans('learning::local.question_essay') && 
                        $question->question_type != trans('learning::local.question_paragraph') &&
                        $question->question_type != trans('learning::local.question_matching'))
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
                        @endif
                        
                        {{-- matching --}}
                        @if ($question->question_type == trans('learning::local.question_matching'))
                            <input type="hidden" name="question_id[]" value="{{$question->id}}">
                            <input type="hidden" name="question_type[]" value="{{$question->question_type}}">
                            <div class="row">
                                <div class="col-lg-9 col-md-12">
                                    <ol>
                                    @foreach ($question->matchings->shuffle() as $matching)
                                        <li>
                                            <strong>{{$matching->matching_item}}</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            [ @foreach ($question->answers as $answer)                            
                                                <label class="pos-rel">
                                                    <input type="radio" class="ace" name="{{$question->id}}_{{$answer->id}}[]" value="{{$answer->answer_text}}">
                                                    <span class="lbl"></span> {{$answer->answer_text}}                               
                                                </label>                                                      
                                            @endforeach  ]                                      
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
                    <div class="form-group center">
                        <button type="submit" class="btn btn-info">{{ trans('student.end_exam') }}</button>
                    </div>
              </form>
                
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('script')
<script>

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text(minutes + ":" + seconds);

        if (--timer < 0) {
            timer = duration;
        }
        var text = $('#time').text()
        if (text == '00:00') {
            $('#formData').submit();
        }
    }, 1000);
}

jQuery(function ($) {
    var fiveMinutes = 60 * {{$exam->duration}},
        display = $('#time');
    startTimer(fiveMinutes, display);

});
    </script>    
@endsection

