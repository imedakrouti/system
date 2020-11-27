@extends('layouts.front-end.student.index')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>      
    </div>      
</div>

<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="red center"><strong>{{$exam->exam_name}}</strong></h1>
                    <h4 class="black center">
                        <strong>
                            {{ trans('learning::local.subject_type') }}
                                <span class="blue">{{session('lang') == 'ar' ? $exam->subjects->ar_name : $exam->subjects->en_name}}</span>
                             {{ trans('learning::local.division') }}
                                @foreach ($exam->divisions as $division)
                                    <span class="blue">[{{session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name}}]</span>
                                @endforeach
                             {{ trans('learning::local.grade') }}
                                @foreach ($exam->grades as $grade)
                                    <span class="blue">[{{session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name}}]</span>
                                @endforeach
                        </strong>
                    </h4>      
                    <h4 class="black center"><strong>{{ trans('learning::local.duration') }}
                        <span class="blue"> {{$exam->duration}}</span>
                        {{ trans('learning::local.minute') }}</strong></h4>             
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
              <form id="formData" action="">
                @csrf                               
                @foreach ($questions as $question)
                    <div class="bs-callout-info callout-border-left callout-square callout-bordered callout-transparent mt-1 p-1">
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
                                                <textarea name="essay" class="form-control" cols="30" rows="10"></textarea>
                                            </div>
                                        @endif

                                        @if ($question->question_type == trans('learning::local.question_complete'))
                                        <div class="form-group mt-1">
                                            <input type="text" class="form-control">
                                        </div>
                                    @endif
                                    </h4>
                                </div>                                                               
                            @endif
                        
                        @if ($question->question_type != trans('learning::local.question_essay') && $question->question_type != trans('learning::local.question_matching'))
                            @if ($question->question_type != trans('learning::local.question_complete'))                                                                                
                                @foreach ($question->answers->shuffle() as $answer)                        
                                    <h5 class="black">
                                        <label class="pos-rel">
                                            <input type="radio" class="ace" name="{{$question->id}}" value="{{$question->id}}">
                                            <span class="lbl"></span> {{$answer->answer_text}} 
                                     
                                        </label>                                
                                    </h5>
                                @endforeach                                                            
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
                                            [ @foreach ($question->answers as $answer)                            
                                                <label class="pos-rel">
                                                    <input type="radio" class="ace" name="{{$matching->id}}" value="true">
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

              </form>
                
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

