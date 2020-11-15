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
            <li class="breadcrumb-item"><a href="{{route('teacher-classes.index')}}">{{ trans('learning::local.teacher_classes') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('teacher-classes.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.employee_name') }}</label> <br>
                          <select name="employee_id[]" id="employee_id" class="form-control select2" required multiple>
                              <option value="">{{ trans('staff::local.select') }}</option>
                              @foreach ($employees as $employee)
                                  <option {{old('employee_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                                  @if (session('lang') == 'ar')
                                  [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                  @else
                                  [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$employee->en_th_name}}
                                  @endif
                                  </option>
                              @endforeach
                          </select> <br>
                          <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                        </div>
                    </div>    
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                            <select name="division_id" class="form-control" id="filter_division_id">
                                <option value="">{{ trans('student::local.divisions') }}</option>
                                @foreach ($divisions as $division)
                                    <option value="{{$division->id}}">
                                        {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row"> 
                            <select name="grade_id" class="form-control" id="filter_grade_id">
                                <option value="">{{ trans('student::local.grades') }}</option>
                                @foreach ($grades as $grade)
                                    <option value="{{$grade->id}}">
                                        {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                    </div>                        
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                          <label>{{ trans('learning::local.classrooms') }}</label>
                          <select name="classroom_id[]" class="form-control select2" id="filter_room_id" multiple required disabled>
                            <option value="">{{ trans('learning::local.classrooms') }}</option>                    
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                                                 
                                                                             
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher-classes.index')}}';">
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
      filter();
    });      
    function getRooms()
    {
          var filter_division_id = $('#filter_division_id').val();  
          var filter_grade_id = $('#filter_grade_id').val();  

          if (filter_grade_id == '' || filter_division_id == '') // is empty
          {
            $('#filter_room_id').prop('disabled', true); // set disable
            $('#to_room_id').prop('disabled', true); // set disable
          }
          else // is not empty
          {
            $('#filter_room_id').prop('disabled', false);	// set enable
            $('#to_room_id').prop('disabled', false);	// set enable
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
                $('#to_room_id').html(data);
              }
            });
          }
    }          
    </script>
@endsection
