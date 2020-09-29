@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('transfers.index')}}">{{ trans('student::local.transfers') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('transfers.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
                    @include('layouts.backEnd.includes._msg')

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.student_name') }}</label>
                              <div class="col-md-9">
                                <select name="student_id" id="student_id" class="form-control select2" required>
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    @foreach ($students as $student)
                                        <option {{old('student_id') == $student->id ? 'selected' :''}} value="{{$student->id}}">
                                        @if (session('lang') == 'ar')
                                        [{{$student->student_number}}] {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}
                                        @else
                                        [{{$student->student_number}}] {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}
                                        @endif
                                        </option>
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                                <h5 class="mt-1"><strong>{{ trans('student::local.current_grade_id') }}</strong> : <span class="purple" id="current_grade"></span></h5>
                                <h5><strong>{{ trans('student::local.next_grade') }}</strong> : <span class="purple" id="next_grade"></span></h5>
                                <h5><strong>{{ trans('student::local.division') }}</strong> : <span class="purple" id="division"></span></h5>
                              </div>
                            </div>
                        </div>                             
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.leaved_date') }}</label>
                              <div class="col-md-9">                         
                                  <input type="date" class="form-control" name="leaved_date" value="{{old('leaved_date')}}">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.next_year_id') }}</label>
                              <div class="col-md-9">
                                <select name="year_id" class="form-control" required>
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    @foreach ($years as $year)
                                        <option {{old('year_id') == $year->id?'selected':''}} value="{{$year->id}}">{{$year->name}}</option>
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>                                                 
                    </div>   

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.school_fees') }}</label>                         
                              <div class="col-md-9">
                                <select name="school_fees" class="form-control" required>                                
                                    <option {{old('school_fees') == 'yes'?'selected':''}} value="yes">{{ trans('student::local.yes') }}</option>
                                    <option {{old('school_fees') == 'no'?'selected':''}}  value="no">{{ trans('student::local.no') }}</option>                                
                                </select>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.school_books') }}</label>                         
                              <div class="col-md-9">
                                <select name="school_books" class="form-control" required>                                
                                    <option {{old('school_fees') == 'yes'?'selected':''}}  value="yes">{{ trans('student::local.yes') }}</option>
                                    <option {{old('school_fees') == 'no'?'selected':''}}  value="no">{{ trans('student::local.no') }}</option>                                
                                </select>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>                         
                    </div> 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.to_school') }}</label>
                              <div class="col-md-9">
                                <select name="school_id" class="form-control select2" required>
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    @foreach ($schools as $school)
                                        <option {{old('school_id') == $school->id?'selected':''}}  value="{{$school->id}}">{{$school->school_name}}</option>
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.leave_reason') }}</label>
                              <div class="col-md-9">                         
                                  <textarea name="leave_reason" class="form-control" required cols="30" rows="5">{{old('leave_reason')}}</textarea>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>  
                    </div>
                                   
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('transfers.index')}}';">
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
    $('#student_id').on('change', function(){
            var student_id = $(this).val();  
                  
            //using
            $.ajax({
                url:'{{route("students.getGradesData")}}',
                type:"post",
                data: {
                _method		    : 'PUT',
                student_id 	    : student_id,                
                _token		    : '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data){
                $('#current_grade').html(data.current_grade_id);                
                $('#next_grade').html(data.next_grade_id);                
                $('#division').html(data.division);                
                }
            });              
    });         
</script>
@endsection
