@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('exams.index')}}">{{ trans('learning::local.exams') }}</a></li>
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
            <h5><strong>{{ trans('learning::local.exam_name') }} : </strong>{{$exam->exam_name}}</h5>
            <h5><strong>{{ trans('learning::local.subject_type') }} : </strong>
                {{session('lang') == 'ar' ? $exam->subjects->ar_name : $exam->subjects->en_name}}</h5>
            <h5><strong>{{ trans('learning::local.start_date') }} : </strong>{{$exam->start_date}} - {{$exam->start_time}}</h5>
            <h5><strong>{{ trans('learning::local.end_date') }} : </strong>{{$exam->end_date}} - {{$exam->end_time}}</h5>
            <h5><strong>{{ trans('learning::local.exam_duration') }} : </strong>{{$exam->duration}}</h5>
            <h5><strong>{{ trans('learning::local.total_mark') }} : </strong>{{$exam->total_mark}}</h5>
            <p>{{$exam->description}}</p>
   
            <div class="btn-group mr-1 mb-1">
                <a href="#" class="btn btn-danger mr-1"><i class="la la-trash"></i> {{ trans('admin.delete') }}</a>
                <button type="button" class="btn btn-success btn-min-width dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.add_question') }}</button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" onclick="multiChoice()" href="#">{{ trans('learning::local.multiple_choice') }}</a>
                  <a class="dropdown-item" onclick="trueFalse()" href="#">{{ trans('learning::local.true_false') }}</a>
                  <a class="dropdown-item" onclick="complete()" href="#">{{ trans('learning::local.complete') }}</a>
                  <a class="dropdown-item" onclick="matching()" href="#">{{ trans('learning::local.matching') }}</a>
                  <a class="dropdown-item" onclick="essay()" href="#">{{ trans('learning::local.essay') }}</a>                                    
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
                @foreach ($questions as $question)
                    <div class="bs-callout-info callout-border-left callout-square callout-bordered callout-transparent mt-1 p-1">
                        <strong class="black">{{$question->question_type}} <span class="blue">{{ trans('learning::local.mark') }} {{$question->mark}}</span></strong>
                        @if ($question->question_type != trans('learning::local.question_matching'))
                            <div class="mb-1 mt-1">
                                <h4 class="red">
                                    <label class="pos-rel">
                                        <input type="checkbox" class="ace" name="{{$question->id}}" value="true">
                                        <span class="lbl"></span> {{$question->question_text}}                               
                                    </label>  
                                </h4>
                            </div>                               
                        @endif
                        @if ($question->question_type != trans('learning::local.essay') && $question->question_type != trans('learning::local.question_matching'))
                            @foreach ($question->answers as $answer)                        
                                <h5 class="black">
                                    <label class="pos-rel">
                                        <input type="radio" class="ace" name="{{$question->id}}" value="true">
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
                        @endif

                        @if ($question->question_type == trans('learning::local.question_matching'))
                                <div class="row">
                                  <div class="col-lg-9 col-md-12">
                                      <ol>
                                        @foreach ($question->matchings as $matching)
                                            <li>
                                                <strong>{{$matching->matching_item}}</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                @foreach ($question->answers as $answer)                            
                                                    <label class="pos-rel">
                                                        <input type="radio" class="ace" name="{{$matching->id}}" value="true">
                                                        <span class="lbl"></span> {{$answer->answer_text}}                               
                                                    </label>  
                                                    
                                                @endforeach
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                [<span class="success">{{ trans('learning::local.right_answer') }}</span> : {{$matching->matching_answer}}]
                                            </li>
                                        @endforeach
                                      </ol>
                                  </div>
                                  <div class="col-lg-3 col-md-12">
                                      <ol type="I">
                                        @foreach ($question->answers as $answer)
                                            <li>{{$answer->answer_text}}</li>
                                        @endforeach
                                      </ol>
                                  </div>
                                </div>

                        @endif
                        
                       
                    </div>
                @endforeach
                
          </div>
        </div>
      </div>
    </div>
</div>

@include('learning::exams.includes._multi-choice')
@include('learning::exams.includes._true-false')
@include('learning::exams.includes._complete')
@include('learning::exams.includes._matching')
@include('learning::exams.includes._essay')
@endsection
@section('script')
    <script>
        function multiChoice()
        {
            $('#exam_id').val({{$exam->id}});			
            $('#multiple_choice').modal({backdrop: 'static', keyboard: false})
            $('#multiple_choice').modal('show');
        }

        function trueFalse()
        {
            $('#true_false_exam_id').val({{$exam->id}});			
            $('#trueFalse').modal({backdrop: 'static', keyboard: false})
            $('#trueFalse').modal('show');
        }

        function complete()
        {
            $('#complete_exam_id').val({{$exam->id}});			
            $('#complete').modal({backdrop: 'static', keyboard: false})
            $('#complete').modal('show');
        }

        function matching()
        {
            $('#matching_exam_id').val({{$exam->id}});			
            $('#matching').modal({backdrop: 'static', keyboard: false})
            $('#matching').modal('show');
        }

        function essay()
        {
            $('#essay_exam_id').val({{$exam->id}});			
            $('#essay').modal({backdrop: 'static', keyboard: false})
            $('#essay').modal('show');
        }
    </script>
    <script src="{{asset('cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@endsection
