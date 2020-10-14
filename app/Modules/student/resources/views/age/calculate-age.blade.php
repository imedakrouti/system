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
          <div class="col-lg-6 col-md-12">
            <div class="form-group">            
               <h3 class="blue">{{ trans('student::local.dob_in_st_october_for_year') }} {{fullAcademicYear()}}</h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="form-group">
                <label>{{ trans('student::local.student_dob') }}</label>
                <input type="date" class="form-control" name="dob" id="dob">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group row">
                <div class="col-md-2">
                  <input type="text" class="form-control center" value="0" id="dd" readonly>
                  <span>{{ trans('student::local.dd') }}</span>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control center" value="0" id="mm" readonly>
                  <span>{{ trans('student::local.mm') }}</span>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control center" value="0" id="yy" readonly>
                  <span>{{ trans('student::local.yy') }}</span>
                </div>                                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
      $('#dob').on('change',function(){        
        var dob    = $('#dob').val();
        $.ajax({
          type:'POST',
          url:'{{route("student.age")}}',
          data: {
              _method     : 'PUT',
              dob         : dob,              
              _token      : '{{ csrf_token() }}'
          },
          success:function(response){
            $('#dd').val(response.data.dd);
            $('#mm').val(response.data.mm);
            $('#yy').val(response.data.yy);            
          }
        })

      })    
    </script>
@endsection

 