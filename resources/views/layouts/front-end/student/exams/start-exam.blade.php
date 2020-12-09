@extends('layouts.front-end.student.index')
@section('styles')
<style>
    
    /* Hide all steps by default: */
    .tab {
      display: none;
    }
    
    
    /* Make circles that indicate the steps of the form: */
    .step {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbbbbb;
      border: none;  
      border-radius: 50%;
      display: inline-block;
      opacity: 0.5;
    }
    
    .step.active {
      opacity: 1;
    }
    
    /* Mark the steps that are finished and valid: */
    .step.finish {
      background-color: #4CAF50;
    }
    </style>
@endsection
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
                        {{ trans('student.minutes') }}</strong></h4>
                        <h1 class="center blue" style="font-size: 60px"><span id="time">00:00</span> {{ trans('student.minutes') }}</h1>             
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
                    <input type="hidden" name="exam_id" value="{{$exam->id}}">
             
                    @foreach ($questions as $question)
                            <div class="tab">
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
                                    
                            </div>   
                    
                        @php
                            $n++;
                        @endphp
                    @endforeach
                    <div style="overflow:auto;">
                        <div style="float:right;">
                          <button type="button" class="btn btn-info" id="prevBtn" onclick="nextPrev(-1)">{{ trans('student.previous') }}</button>
                          <button type="button" class="btn btn-info" id="nextBtn" onclick="nextPrev(1)">{{ trans('student.next') }}</button>
                        </div>
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
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        
        function showTab(n) {
                // This function will display the specified tab of the form...
                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";
                //... and fix the Previous/Next buttons:
                if (n == 0) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "inline";
                }
                if (n == (x.length - 1)) {
                    document.getElementById("nextBtn").innerHTML = "{{ trans('student.end_exam') }}";
                } else {
                    document.getElementById("nextBtn").innerHTML = "{{ trans('student.next') }}";
                }
                //... and run a function that will display the correct step indicator:
                fixStepIndicator(n)
        }
        
        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("formData").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }
        
        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
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

