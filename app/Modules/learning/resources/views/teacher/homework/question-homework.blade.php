@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
        .dropdown-item {    
            padding: 0.25rem 0.5rem;
        }        
    </style>
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title"><a href="{{route('teacher.homeworks')}}">{{ trans('learning::local.class_work') }}</a></h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">                 
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div> 
    <div class="content-header-right col-md-6 col-12 mb-1" style="margin-left: -50px">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-primary btn-min-width dropdown-toggle round" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.share') }}</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" onclick="share()" href="#"><i class="la la-share-alt"></i> {{ trans('learning::local.share') }}</a>
                <a class="dropdown-item" onclick="deleteQuestions()" href="#"><i class="la la-trash"></i> {{ trans('learning::local.delete_question') }}</a>                
            </div>            
        </div>
        <div class="btn-group mr-1 float-right">
            <button type="button" class="btn btn-success btn-min-width dropdown-toggle round" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.add_question') }}</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" onclick="multiChoice()" href="#"><i class="la la-question"></i> {{ trans('learning::local.multiple_choice') }}</a>
                <a class="dropdown-item" onclick="trueFalse()" href="#"><i class="la la-question"></i> {{ trans('learning::local.true_false') }}</a>
                <a class="dropdown-item" onclick="complete()" href="#"><i class="la la-question"></i> {{ trans('learning::local.complete') }}</a>                
            </div>            
        </div>
    </div>     
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body" style="min-height: 300px;">
            <div class="row">
              <div class="col-12">                  

                  <h4>{{ trans('learning::local.questions_count') }} : {{count($questions)}}</h4>
                  <form id="formData" action="">
                    @csrf      
                    <input type="hidden" name="homework_id" value="{{$homework->id}}">                         
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
                                                <span class="lbl"></span> <span class="red"><strong>{!!$question->question_text!!}</strong></span>                               
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

                  <!-- /btn-group -->
                  
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    <h4 class="red mb-2"><strong>{{$homework->title}}</strong></h4 class="red">
                    <h5 class="mb-1"><strong>{{ trans('learning::local.subject') }} : </strong>
                        {{session('lang') == 'ar' ? $homework->subject->ar_name : $homework->subject->en_name}}</h5>
                        
                    <h5 class="mb-1"><strong>{{ trans('learning::local.due_date') }} : </strong>
                        @empty($homework->due_date)
                            {{ trans('learning::local.undefined') }}
                        @endempty
                        {{$homework->due_date}}
                    </h5>
                    <h5 class="mb-1"><strong>{{ trans('learning::local.total_mark') }} : </strong>{{$homework->total_mark}}</h5>

                    <h5><strong>{{ trans('learning::local.classrooms') }}  </strong></h5>
                    @foreach ($homework->classrooms as $classroom)
                        <div class="mb-1 badge badge-info">
                            <span><a target="_blank" href="{{route('posts.index',$classroom->id)}}">{{session('lang') == 'ar' ?$classroom->ar_name_classroom : $classroom->en_name_classroom}}</a></span>
                            <i class="la la-book font-medium-3"></i>
                        </div>
                    @endforeach

                    <h5><strong>{{ trans('learning::local.lessons') }}  </strong></h5>
                    @foreach ($homework->lessons as $lesson)
                        <div class="mb-1 badge badge-primary">
                            <span><a target="_blank" href="{{route('teacher.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id])}}">
                                {{$lesson->lesson_title}}</a></span>
                            <i class="la la-book font-medium-3"></i>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
  </div>

@include('learning::teacher.homework.includes._multi-choice')
@include('learning::teacher.homework.includes._true-false')
@include('learning::teacher.homework.includes._complete')
@include('learning::teacher.homework.includes._matching')
@endsection

@section('script')
    <script>
        function multiChoice()
        {
            $('#homework_id').val("{{$homework->id}}");			
            $('#multiple_choice').modal({backdrop: 'static', keyboard: false})
            $('#multiple_choice').modal('show');
        }

        function trueFalse()
        {
            $('#true_false_homework_id').val({{$homework->id}});			
            $('#trueFalse').modal({backdrop: 'static', keyboard: false})
            $('#trueFalse').modal('show');
        }

        function complete()
        {
            $('#complete_homework_id').val({{$homework->id}});			
            $('#complete').modal({backdrop: 'static', keyboard: false})
            $('#complete').modal('show');
        }

        function matching()
        {
            $('#matching_homework_id').val({{$homework->id}});			
            $('#matching').modal({backdrop: 'static', keyboard: false})
            $('#matching').modal('show');
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
        function share()
        {
            var form_data = $('#formData').serialize();
            swal({
                    title: "{{trans('learning::local.share_with_class')}}",
                    text: "{{trans('learning::local.ask_share_homework')}}",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#1e9ff2",
                    confirmButtonText: "{{trans('msg.yes')}}",
                    cancelButtonText: "{{trans('msg.no')}}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('homework.share')}}",
                        method:"POST",
                        data:form_data,
                        dataType:"json",
                        // display succees message
                        success:function(data)
                        {
                            swal("{{trans('learning::local.share_with_class')}}", "{{trans('learning::local.msg_share_classes')}}", "success");
                        }
                    })
                }
            );
        }   
    </script>
    <script src="{{asset('cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@endsection

