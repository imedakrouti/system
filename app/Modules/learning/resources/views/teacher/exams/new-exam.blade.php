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
            <li class="breadcrumb-item">{{ $title }}</li>     
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
          <form class="form form-horizontal" method="POST" action="{{route('teacher.store-exam')}}">
              @csrf
              <div class="form-body">
                  <h4 class="form-section"> {{ $title }}</h4>
                  @include('layouts.backEnd.includes._msg')   
                  <div class="col-lg-8 col-md-12">
                    <div class="form-group row">
                        <label>{{ trans('learning::local.exam_name') }}</label>
                        <input type="text" class="form-control" name="exam_name" value="{{old('exam_name')}}" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-4 col-md-6">
                      <div class="form-group">
                          <label>{{ trans('learning::local.division') }}</label>
                          <select name="divisions[]" class="form-control select2" id="filter_division_id" required multiple>                                                                  
                              @foreach ($divisions as $division)
                                  <option value="{{$division->id}}">
                                      {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                              
                      </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                      <div class="form-group"> 
                          <label>{{ trans('learning::local.grade') }}</label>
                          <select name="grades[]" class="form-control select2" id="filter_grade_id" required multiple>                                    
                            
                            @foreach ($grades as $grade)
                                  <option value="{{$grade->id}}">
                                      {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                              
                      </div>
                  </div>  
                </div>

                <div class="row">
                  <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label>{{ trans('learning::local.lessons_related_exam') }}</label>
                        <select name="lessons[]" class="form-control select2" multiple required>
                            <option value="">{{ trans('staff::local.select') }}</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{$lesson->id}}">{{$lesson->lesson_title}} 
                                    [{{session('lang') == 'ar' ? $lesson->subject->ar_name : $lesson->subject->en_name}}]</option>
                            @endforeach
                        </select>
                        <span class="red">{{ trans('learning::local.required') }}</span>                              
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                      <label>{{ trans('learning::local.subject') }}</label>
                      <select name="subject_id" class="form-control select2" required>                          
                          @foreach (employeeSubjects() as $subject)
                              <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                  {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                          @endforeach
                      </select>
                      <span class="red">{{ trans('learning::local.required') }}</span>                              
                    </div>
                  </div>

                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.start_date') }}</label>
                          <input type="date"  class="form-control " value="{{old('start_date')}}"
                            name="start_date" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.start_time') }}</label>
                          <input type="time" class="form-control " value="{{old('start_time')}}"
                            name="start_time" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                                                                                                                                 
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.end_date') }}</label>
                          <input type="date"  class="form-control " value="{{old('end_date')}}"
                            name="end_date" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.end_time') }}</label>
                          <input type="time" class="form-control " value="{{old('end_time')}}"
                            name="end_time" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                                                                                                                                 
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.exam_duration') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('duration')}}"
                            name="duration" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.total_mark') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('total_mark')}}"
                            name="total_mark" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>    
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.no_question_per_page') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('no_question_per_page')}}"
                            name="no_question_per_page" required>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.auto_correct') }}</label>
                          <select name="auto_correct" class="form-control">
                            <option {{old('auto_correct') == 'no' ? 'selected' : ''}} value="no">{{ trans('learning::local.no') }}</option>
                            <option {{old('auto_correct') == 'yes' ? 'selected' : ''}} value="yes">{{ trans('learning::local.yes') }}</option>
                          </select>                          
                        </div>
                    </div>                                                                                                                                
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="form-group row">
                        <label>{{ trans('learning::local.description') }}</label>
                        <textarea required name="description" class="form-control" cols="30" rows="5">{{old('description')}}</textarea>
                        <span class="red">{{ trans('learning::local.required') }}</span>                              
                    </div>
                </div>                                                                             
              </div>
              <div class="form-actions left">
                  <button type="submit" class="btn btn-success">
                      <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                    </button>
                  <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher.view-exams')}}';">
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
<script>
    $('#filter_division_id').on('change', function(){
      getRooms();
    });  
    $('#filter_grade_id').on('change', function(){
      getRooms();      
    });      
    function getRooms()
    {
          var filter_division_id = $('#filter_division_id').val();  
          var filter_grade_id = $('#filter_grade_id').val();  

          if (filter_grade_id == '' || filter_division_id == '') // is empty
          {
            $('#filter_room_id').prop('disabled', true); // set disable            
          }
          else // is not empty
          {
            $('#filter_room_id').prop('disabled', false);	// set enable            
            //using
            $.ajax({
              url:'{{route("getClassrooms")}}',
              type:"post",
              data: {
                _method		    : 'PUT',
                division_id 	: filter_division_id,
                grade_id 	    : filter_grade_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){
                $('#filter_room_id').html(data);                
              }
            });
          }
    }    
</script>
 
@endsection
