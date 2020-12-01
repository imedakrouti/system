@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('teacher.view-exams')}}">{{ trans('learning::local.exams') }}</a></li>       
            <li class="breadcrumb-item"><a href="{{route('teacher.show-exam',$question->exam_id)}}">{{ trans('learning::local.exams') }}</a></li>       
            <li class="breadcrumb-item">{{$title}}
            </li>       
            
          </ol>
        </div>
      </div>
    </div>    
</div>

<div class="row mt-1">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
            <form class="form form-horizontal" method="POST" action="{{route('teacher.update-question',$question->id)}}" enctype="multipart/form-data">
              @csrf
              <div class="form-body">
                  <h4 class="form-section"> {{ $title }}</h4>
                  @include('layouts.backEnd.includes._msg')   
                  <input type="hidden" name="question_id" value="{{$question->id}}">
                  <input type="hidden" name="question_type" value="{{$question->question_type}}">
                  
                  {{-- essay --}}
                  @if ($question->question_type ==  trans('learning::local.question_essay'))
                      <div class="col-lg-12 col-md-12">
                          <div class="form-group">
                              <label>{{ trans('learning::local.question_text') }}</label>
                              <textarea name="question_text" class="form-control" cols="30" rows="5">{{old('question_text',$question->question_text)}}</textarea>
                          </div>
                      </div>
                      <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>{{ trans('learning::local.correct_answer') }}</label>
                                @foreach ($question->answers as $answer)
                                    @if ($question->id == $answer->question_id)
                                        <textarea name="answer_text" class="form-control" cols="30" rows="10">{{old('answer_text',$answer->answer_text)}}</textarea>                                                                            
                                    @endif
                                @endforeach
                            </div>
                      </div>
                      <div class="col-lg-1 col-md-2">
                          <div class="form-group">
                              <label>{{ trans('learning::local.mark') }}</label>
                              <input type="number" min="0" class="form-control" name="mark" value="{{old('mark',$question->mark)}}">
                          </div>
                      </div>

                  @endif  

                  {{-- paragraph --}}
                  @if ($question->question_type ==  trans('learning::local.question_paragraph'))
                      <div class="col-lg-12 col-md-12">
                          <div class="form-group">
                              <label>{{ trans('learning::local.question_text') }}</label>                                
                              <textarea class="form-control" name="question_text" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('question_text',$question->question_text)}}</textarea>                          
                          </div>
                      </div>
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>{{ trans('learning::local.correct_answer') }}</label>
                            @foreach ($question->answers as $answer)
                                @if ($question->id == $answer->question_id)
                                    <textarea name="answer_text" class="form-control" cols="30" rows="10">{{old('answer_text',$answer->answer_text)}}</textarea>                                                                            
                                @endif
                            @endforeach
                        </div>
                      </div>                      
                      <div class="col-lg-2 col-md-2">
                          <div class="form-group">
                              <label>{{ trans('learning::local.mark') }}</label>
                              <input type="number" min="0" class="form-control" name="mark" value="{{old('mark',$question->mark)}}">
                          </div>
                      </div>

                  @endif                      
                  
                  {{-- true or false --}}
                  @if ($question->question_type ==  trans('learning::local.question_true_false'))
                      <div class="col-lg-12 col-md-12">
                          <div class="form-group row">
                              <label>{{ trans('learning::local.question_text') }}</label>
                              <textarea name="question_text" class="form-control" cols="30" rows="5">{{old('question_text',$question->question_text)}}</textarea>
                          </div>
                      </div>
                      <div class="col-lg-2 col-md-2">
                          <div class="form-group row">
                              <label>{{ trans('learning::local.mark') }}</label>
                              <input type="number" min="0" class="form-control" name="mark" value="{{old('mark',$question->mark)}}">
                          </div>
                      </div>

                      @foreach ($question->answers as $answer)
                          <div class="row">
                              <div class="col-lg-4 col-md-4">
                                  <div class="form-group">
                                      <input type="text"  name="answer_text[]" class="form-control" readonly value="{{$answer->answer_text}}">
                                  </div>
                              </div>
                              <div class="col-lg-4 col-md-4">
                                  <div class="form-group">
                                      <input type="text"  name="answer_note[]" class="form-control" value="{{$answer->answer_note}}" placeholder="{{ trans('learning::local.answer_feedback') }}">
                                  </div>
                              </div>
                              <div class="col-lg-4 col-md-4">
                                  <div class="form-group">
                                      <select name="right_answer[]" class="form-control" required>
                                          <option {{$answer->right_answer == 'false' ? 'selected' : ''}} value="false">{{ trans('learning::local.other') }}</option>
                                          <option {{$answer->right_answer == 'true' ? 'selected' : ''}} value="true">{{ trans('learning::local.right_answer') }}</option>
                                      </select>
                                  </div>
                              </div>
                          </div>                            
                      @endforeach

                  @endif 
                  
                  {{-- multi choices --}}
                  @if ($question->question_type ==  trans('learning::local.question_multiple_choice') ||
                  $question->question_type ==  trans('learning::local.question_complete'))
                      <div class="col-lg-12 col-md-12">
                          <div class="form-group">
                              <label>{{ trans('learning::local.question_text') }}</label>
                              <textarea name="question_text" class="form-control" cols="30" rows="5">{{old('question_text',$question->question_text)}}</textarea>
                          </div>
                      </div>
                      <div class="col-lg-2 col-md-2">
                          <div class="form-group">
                              <label>{{ trans('learning::local.mark') }}</label>
                              <input type="number" min="0" class="form-control" name="mark" value="{{old('mark',$question->mark)}}">
                          </div>
                      </div>

                      <div class="form-group col-12 mb-2 contact-repeater">
                        <div data-repeater-list="repeater-group">
                            @foreach ($question->answers as $answer)
                                    <div class="input-group mb-1" data-repeater-item>
                                      <input type="text" value="{{$answer->answer_text}}" name="answer_text" required  class="form-control" placeholder="{{ trans('learning::local.choices') }}" id="example-tel-input">                        
                                      <input type="text" value="{{$answer->answer_note}}" name="answer_note" required  class="form-control" placeholder="{{ trans('learning::local.answer_feedback') }}" id="example-tel-input">
                                      <select name="right_answer" class="form-control" required>
                                          <option {{$answer->right_answer == 'false' ? 'selected' : ''}} value="false">{{ trans('learning::local.other') }}</option>
                                          <option {{$answer->right_answer == 'true' ? 'selected' : ''}} value="true">{{ trans('learning::local.right_answer') }}</option>
                                      </select> 
                                      <span class="input-group-append" id="button-addon2">
                                        <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                                      </span>
                                    </div>
                            @endforeach                                  
                        </div>
                    </div> 
                  @endif  

                  {{-- matching --}}
                  @if ($question->question_type ==  trans('learning::local.question_matching'))
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>{{ trans('learning::local.mark') }}</label>
                            <input type="number" min="0" class="form-control" name="mark" value="{{old('mark',$question->mark)}}">
                        </div>
                    </div>

                    <div class="form-group col-12 mb-2 contact-repeater">
                        <label><strong>{{ trans('learning::local.column_a') }}</strong></label>
                        <div data-repeater-list="repeater-group-a">
                            @foreach ($question->matchings as $matching)
                                    <div class="input-group mb-1" data-repeater-item>
                                      <input type="text" value="{{$matching->matching_item}}" name="matching_item" required  class="form-control" placeholder="{{ trans('learning::local.item_name') }}" id="example-tel-input">                                            
                                      <input type="text" value="{{$matching->matching_answer}}" name="matching_answer" required  class="form-control" placeholder="{{ trans('learning::local.right_answer') }}" id="example-tel-input">                                       
                                    </div>
                            @endforeach                                  
                        </div>
                    </div> 
                    <div class="form-group col-12 mb-2 contact-repeater">
                      <label><strong>{{ trans('learning::local.column_b') }}</strong></label>
                      <div data-repeater-list="repeater-group-b">
                          @foreach ($question->answers as $answer)
                                  <div class="input-group mb-1" data-repeater-item>
                                    <input type="text" value="{{$answer->answer_text}}"  name="answer_text" required  class="form-control" placeholder="{{ trans('learning::local.item_name') }}" id="example-tel-input">                                                  
                                  </div>
                          @endforeach                                  
                      </div>
                  </div> 
                  @endif 

                  @if ($question->question_type ==  trans('learning::local.question_essay') || 
                      $question->question_type ==  trans('learning::local.question_paragraph') || 
                      $question->question_type ==  trans('learning::local.question_true_false') || 
                      $question->question_type ==  trans('learning::local.question_complete'))
                      <div class="col-lg-4 col-md-12">
                          @isset($question->file_name)
                              <div class="form-group center">                                    
                                  <img class="mt-1" width="600" src="{{asset('images/questions_attachments/'.$question->file_name)}}" alt="" >
                              </div>
                              <div class="form-group">
                                  <label class="pos-rel">
                                      <input type="checkbox" class="ace" name="remove_image" value="true">
                                      <span class="lbl"></span> {{ trans('learning::local.remove_image') }}
                                  </label>
                              </div>
                          @endisset
                      </div> 
                      <div class="col-lg-4 col-md-12">
                          <div class="form-group">
                              <label>{{ trans('learning::local.add_image') }}</label>
                              <input type="file" class="form-control" name="file_name">
                          </div>
                      </div>                        
                  @endif                                                                                   
              </div>
              <div class="form-actions left">
                  <button type="submit" class="btn btn-success">
                      <i class="la la-check-square-o"></i> {{ trans('admin.save_changes') }}
                    </button>
                  <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher.show-exam',$question->exam_id)}}';">
                  <i class="ft-x"></i> {{ trans('admin.cancel') }}
                </button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>

<script src="{{asset('cpanel/app-assets/vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('cpanel/app-assets/js/scripts/editors/editor-ckeditor.js')}}"></script>  
@endsection
