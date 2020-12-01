@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('teacher.view-exams')}}">{{ trans('learning::local.exams') }}</a>
            </li>       
            <li class="breadcrumb-item">{{$exam->exam_name}}
            </li>       
            
          </ol>
        </div>
      </div>
    </div>  
</div>

<div class="row mt-1">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-lg-4 col-md-12">
                    <h5><strong>{{ trans('learning::local.exam_name') }} : </strong>{{$exam->exam_name}}</h5>
                    <h5><strong>{{ trans('learning::local.subject_type') }} : </strong>
                        {{session('lang') == 'ar' ? $exam->subjects->ar_name : $exam->subjects->en_name}}</h5>
                    <h5><strong>{{ trans('learning::local.start_date') }} : </strong>{{$exam->start_date}} - {{$exam->start_time}}</h5>
                    <h5><strong>{{ trans('learning::local.end_date') }} : </strong>{{$exam->end_date}} - {{$exam->end_time}}</h5>
                    <h5><strong>{{ trans('learning::local.exam_duration') }} : </strong>{{$exam->duration}}</h5>
                    <h5><strong>{{ trans('learning::local.total_mark') }} : </strong>{{$exam->total_mark}}</h5>
                    <h5><strong>{{ trans('learning::local.auto_correct') }} : </strong>{{$exam->auto_correct}}</h5>
                    <p>{{$exam->description}}</p>           
                </div>

                <div class="col-lg-3 col-md-12">                    
                    <div class="form-group">
                        <h5><strong>{{ trans('learning::local.divisions_related_exam') }}</strong></h5>
                        @foreach ($exam->divisions as $division)                            
                            <div class="mb-1 badge badge-info">
                                <span>{{session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name}}</span>
                                <i class="la la-book font-medium-3"></i>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h5><strong>{{ trans('learning::local.grades_related_exam') }}</strong></h5>
                        @foreach ($exam->grades as $grade)                            
                            <div class="mb-1 badge badge-info">
                                <span>{{session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name}}</span>
                                <i class="la la-book font-medium-3"></i>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h5><strong>{{ trans('learning::local.lessons_related_exam') }}</strong></h5>
                        @foreach ($exam->lessons as $lesson)                            
                            <div class="mb-1 badge badge-info">
                                <span><a target="_blank" href="{{route('teacher.view-lesson',['id' =>$lesson->id,'playlist_id'=>$lesson->playlist_id])}}">{{$lesson->lesson_title}}</a></span>
                                <i class="la la-book font-medium-3"></i>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    <h5><strong>{{ trans('learning::local.created_exam_by') }} : 
                        </strong>{{session('lang') == 'ar' ?$exam->admin->ar_name :$exam->admin->name}}
                    </h5>
                    <h5><strong>{{ trans('learning::local.created_at') }} : </strong>{{$exam->created_at->diffForHumans()}}</h5>
                    <h5><strong>{{ trans('learning::local.last_updated') }} : </strong>{{$exam->updated_at->diffForHumans()}}</h5>
                    <div class="form-group">
                        <button type="button" class="btn btn-success btn-min-width  dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.add_question') }}</button>
                        <div class="dropdown-menu">
                            @if ($exam->auto_correct == 'no')
                                <a class="dropdown-item" onclick="paragraph()" href="#"><i class="la la-question"></i> {{ trans('learning::local.question_paragraph') }}</a>                                    
                                <a class="dropdown-item" onclick="essay()" href="#"><i class="la la-question"></i> {{ trans('learning::local.question_essay') }}</a>                                                                    
                            @endif
                            <a class="dropdown-item" onclick="multiChoice()" href="#"><i class="la la-question"></i> {{ trans('learning::local.multiple_choice') }}</a>
                            <a class="dropdown-item" onclick="trueFalse()" href="#"><i class="la la-question"></i> {{ trans('learning::local.true_false') }}</a>
                            <a class="dropdown-item" onclick="complete()" href="#"><i class="la la-question"></i> {{ trans('learning::local.complete') }}</a>
                            {{-- <a class="dropdown-item" onclick="matching()" href="#"><i class="la la-question"></i> {{ trans('learning::local.matching') }}</a> --}}
                        </div>
                        <a href="#" onclick="setClasses()" class="btn btn-info ml-1"><i class="la la-share-alt"></i> {{ trans('learning::local.share_with_class') }}</a>              
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="btn-group mr-1 mb-1">                            
                    <a href="{{route('teacher.view-exams')}}" class="btn btn-light ml-1"><i class="la la-mail-forward"></i> {{ trans('admin.back') }}</a>              
                    <a href="#" onclick="deleteQuestions()" class="btn btn-danger ml-1"><i class="la la-trash"></i> {{ trans('admin.delete') }}</a>              
                    <a target="_blank" href="{{route('teacher.preview-exam',$exam->id)}}" class="btn btn-primary ml-1"><i class="la la-spinner"></i> {{ trans('admin.preview') }}</a>              
                    
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
                        <strong class="black">{{$n}} - {{$question->question_type}} <span class="red">{{ trans('learning::local.mark') }} 
                            {{$question->mark}}</span> | <a href="{{route('teacher.edit-question',$question->id)}}">{{ trans('learning::local.edit') }}</a></strong>
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
</div>

@include('learning::teacher.exams.includes._multi-choice')
@include('learning::teacher.exams.includes._true-false')
@include('learning::teacher.exams.includes._complete')
@include('learning::teacher.exams.includes._matching')
@include('learning::teacher.exams.includes._essay')
@include('learning::teacher.exams.includes._paragraph')
@include('learning::teacher.exams.includes._set-classes')
@endsection

@section('script')
    <script>
        function multiChoice()
        {
            $('#exam_id').val("{{$exam->id}}");			
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

        function paragraph()
        {
            $('#paragraph_exam_id').val({{$exam->id}});			
            $('#paragraph').modal({backdrop: 'static', keyboard: false})
            $('#paragraph').modal('show');
        }

        function deleteQuestions()
        {
            var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
            if (itemChecked > 0) {
                var form_data = $('#formData').serialize();
                swal({
                        title: "{{trans('msg.delete_confirmation')}}",
                        text: "{{trans('learning::local.ask_delete_question')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#D15B47",
                        confirmButtonText: "{{trans('msg.yes')}}",
                        cancelButtonText: "{{trans('msg.no')}}",
                        closeOnConfirm: false,
                    },
                    function() {
                        $.ajax({
                            url:"{{route('questions.destroy')}}",
                            method:"POST",
                            data:form_data,
                            dataType:"json",
                            // display succees message
                            success:function(data)
                            {
                              location.reload();
                            }
                        })
                    }
                );
            }	else{
                swal("{{trans('msg.delete_confirmation')}}", "{{trans('msg.no_records_selected')}}", "info");
            }
        }

        function setClasses()
        {            
            $('#exam_classes_id').val("{{$exam->id}}");			
            $('#setClasses').modal({backdrop: 'static', keyboard: false})
            $('#setClasses').modal('show');
        }  
    </script>
    <script src="{{asset('cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>

    <script src="{{asset('cpanel/app-assets/vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('cpanel/app-assets/js/scripts/editors/editor-ckeditor.js')}}"></script>  
@endsection
