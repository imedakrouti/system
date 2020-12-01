@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
        .text-mark{
            width: 7%;
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
            <li class="breadcrumb-item"><a href="{{route('teacher.view-exams')}}">{{ trans('learning::local.exams') }}</a>
            </li>         
            <li class="breadcrumb-item"><a href="{{route('teacher.applicants',$exam->id)}}">{{ trans('learning::local.applicants') }}</a>
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
                    <h2 class="purple"><strong>{!!$student_name!!}</strong> </h2>

                    <table class="table">
                        <thead>
                            <th>{{ trans('student.exam_name') }}</th>
                            <th>{{ trans('student.exam_date') }}</th>
                            <th>{{ trans('student.total_mark') }}</th>
                            <th>{{ trans('student.mark') }}</th>
                            <th>{{ trans('student.evaluation') }}</th>
                            <th>{{ trans('student.right_answer') }}</th>
                            <th>{{ trans('student.wrong_answer') }}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$exam->exam_name}}</td>
                                <td>
                                    @foreach ($exam->userExams as $user_exam)                            
                                        {{\Carbon\Carbon::parse( $user_exam->created_at)->format('M d Y, D h:m a ')}}
                                    @endforeach                                
                                </td>
                                <td>{{$exam->total_mark}}</td>
                                <td>{{$exam->userAnswers->sum('mark')}}</td>
                                <td><strong>{{evaluation($exam->total_mark, $exam->userAnswers->sum('mark'))}}</strong></td>
                                <td>
                                    @php
                                        $right_answers = 0;
                                        foreach ($exam->userAnswers as $answer) {
                                            if ($answer->mark != 0) {
                                                $right_answers ++;
                                            }
                                        }
                                    @endphp 
                                    {{$right_answers}}                                
                                </td>
                                <td>
                                    @php
                                        $wrong_answers = 0;
                                        foreach ($exam->userAnswers as $answer) {
                                            if ($answer->mark == 0) {
                                                $wrong_answers ++;
                                            }
                                        }
                                    @endphp 
                                    {{$wrong_answers}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h4 class="mt-1 mb-1"><strong>{{ trans('student.equivalency') }}</strong></h4>
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
                    <div class="form-group">
                        <a href="#" onclick="addReport()" class="btn btn-primary ">{{ trans('learning::local.add_report') }}</a>
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
                        <button type="submit" class="btn btn-info">{{ trans('student.end_exam') }}</button>
                    </div>
              </form>                
          </div>
        </div>
      </div>
    </div>
</div>
@include('learning::teacher.exams.includes._show-answer')                                    
@include('learning::teacher.exams.includes._add-report')                                    
@endsection
@section('script')
    <script>
        function showAnswer(question_id)
        {                   
            $.ajax({
                url:'{{route("teacher.get-answer")}}',
                type:"post",
                data: {
                    _method		    : 'PUT',                
                    question_id 	: question_id,
                    _token		    : '{{ csrf_token() }}'
                    },
                dataType: 'json',
                success: function(data){
                    $('.answer').val(data);			
                    $('#showAnswerModal').modal({backdrop: 'static', keyboard: false})
                    $('#showAnswerModal').modal('show');
                }
            });          
        }

        function addReport()
        {
            $.ajax({
                url:'{{route("teacher.get-report")}}',
                type:"post",
                data: {
                    _method		    : 'PUT',                
                    exam_id 	    : "{{$exam->id}}",
                    _token		    : '{{ csrf_token() }}'
                    },
                dataType: 'json',
                success: function(data){
                    $('#report').val(data);			
                    
                    $('#exam_id').val({{$exam->id}})
                    $('#addReportModal').modal({backdrop: 'static', keyboard: false})
                    $('#addReportModal').modal('show');
                }
            });            
        }

        $('#frmReport').on('submit',function(e){
				e.preventDefault();
				var form_data = new FormData($(this)[0]);
				swal({
					title: "{{trans('learning::local.report')}}",
					text: "{{trans('learning::local.ask_add_report')}}",
					showCancelButton: true,
					confirmButtonColor: "#87B87F",
					confirmButtonText: "{{trans('msg.yes')}}",
					cancelButtonText: "{{trans('msg.no')}}",
					closeOnConfirm: false,
					},
					function() {
						$.ajax({
							url:"{{route('teacher.exam-report')}}",
							method:"POST",
							data:form_data,
							cache       : false,
							contentType : false,
							processData : false,
							dataType:"json",
							// display succees message
							success:function(data)
							{
							    $('#addReportModal').modal('hide');
								swal("{{trans('learning::local.report')}}", "{{trans('learning::local.add_report_successfully')}}", "success");
							}
						})
						
					}
				);
			});        
    </script>

@endsection
