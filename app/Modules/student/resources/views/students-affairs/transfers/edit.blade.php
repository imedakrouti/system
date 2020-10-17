@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-lg-4 col-md-6 col-12 mb-2">
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
            <form class="form form-horizontal" method="POST" action="{{route('transfers.update',$transfer->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    
                        <div class="row">
                          <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.student_name') }}</label> <br>
                              
                                <select style="width:100%" name="student_id" id="student_id" class="form-control select2" required>
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    @foreach ($students as $student)
                                        <option {{old('student_id',$transfer->student_id) == $student->id ? 'selected' :''}} value="{{$student->id}}">
                                        @if (session('lang') == 'ar')
                                        [{{$student->student_number}}] {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}
                                        @else
                                        [{{$student->student_number}}] {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}
                                        @endif
                                        </option>
                                    @endforeach
                                </select> <br>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                                <h5 class="mt-1"><strong>{{ trans('student::local.current_grade_id') }}</strong> : <span class="purple" id="current_grade"></span></h5>
                                <h5><strong>{{ trans('student::local.next_grade') }}</strong> : <span class="purple" id="next_grade"></span></h5>
                                <h5><strong>{{ trans('student::local.division') }}</strong> : <span class="purple" id="division"></span></h5>
                              
                            </div>
                        </div>                             
                    

                    
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.leaved_date') }}</label> <br>
                                                       
                                  <input type="date" class="form-control" name="leaved_date" value="{{old('leaved_date',$transfer->leaved_date)}}">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              
                            </div>
                        </div>  
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.next_year_id') }}</label> <br>
                              
                                <select style="width:100%" name="year_id" class="form-control" required>
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    @foreach ($years as $year)
                                        <option {{old('year_id',$transfer->next_year_id) == $year->id?'selected':''}} value="{{$year->id}}">{{$year->name}}</option>
                                    @endforeach
                                </select> <br>d
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              
                            </div>
                        </div>                                                 
                       

                    
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.school_fees') }}</label> <br>                         
                              
                                <select style="width:100%" name="school_fees" class="form-control" required>                                
                                    <option {{old('school_fees',$transfer->school_fees) == 'payed' || 
                                    old('school_fees',$transfer->school_fees) == trans('student::local.payed') ?'selected':''}} value="payed">{{ trans('student::local.payed') }}</option>
                                    <option {{old('school_fees',$transfer->school_fees) == 'not_payed' || 
                                      old('school_fees',$transfer->school_fees) == trans('student::local.not_payed') ?'selected':''}}  value="not_payed">{{ trans('student::local.not_payed') }}</option>                                
                                </select> <br>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              
                            </div>
                        </div> 
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.school_books') }}</label> <br>                         
                              
                                <select style="width:100%" name="school_books" class="form-control" required>                                
                                    <option {{old('school_books',$transfer->school_books) == 'received' || 
                                      old('school_books',$transfer->school_books) == trans('student::local.received') ?'selected':''}}  value="received">{{ trans('student::local.received') }}</option>
                                    <option {{old('school_books',$transfer->school_books) == 'not_received' || 
                                      old('school_books',$transfer->school_books) == trans('student::local.not_received') ?'selected':''}}  value="not_received">{{ trans('student::local.not_received') }}</option>                                
                                </select> <br>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              
                            </div>
                        </div>                         
                    

                    
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.to_school') }}</label> <br>
                              
                                <select style="width:100%" name="school_id" class="form-control select2" required>
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    @foreach ($schools as $school)
                                        <option {{old('school_id',$transfer->school_id) == $school->id?'selected':''}}  value="{{$school->id}}">{{$school->school_name}}</option>
                                    @endforeach
                                </select> <br>
                                <span class="red">{{ trans('student::local.requried') }}</span>
                              
                            </div>
                        </div>                        
                    
                    
                    
                        <div class="col-lg-8 col-md-12">
                            <div class="form-group">
                              <label>{{ trans('student::local.leave_reason') }}</label> <br>
                                                       
                                  <textarea name="leave_reason" class="form-control" required cols="30" rows="5">{{old('leave_reason',$transfer->leave_reason)}}</textarea>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              
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
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
            <h5><strong>{{ trans('student::local.created_by') }} :</strong> {{$transfer->admin->name}}</h5>
            <h5><strong>{{ trans('student::local.created_at') }} :</strong> {{$transfer->created_at}}</h5>
            <h5><strong>{{ trans('student::local.updated_at') }} :</strong> {{$transfer->updated_at}}</h5>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
    getGradesData();

    $('#student_id').on('change', function(){
        getGradesData();
    });    
    function getGradesData()
    {
        var student_id = $('#student_id').val();  
                  
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
    }     

</script>
@endsection
