@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('employees.index')}}">{{ trans('staff::local.employees') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('employees.update',$employee->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    @include('staff::employees.includes._edit')                        
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('employees.index')}}';">
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
          $('#sector_id').on('change', function(){
                var sector_id = $(this).val();                  

                if (sector_id == '') // is empty
                {
                  $('#department_id').prop('disabled', true); // set disable                  
                }
                else // is not empty
                {
                  $('#department_id').prop('disabled', false);	// set enable                  
                  //using
                  $.ajax({
                    url:'{{route("getDepartmentsBySectorId")}}',
                    type:"post",
                    data: {
                      _method		    : 'PUT',
                      sector_id 	  : sector_id,                      
                      _token		    : '{{ csrf_token() }}'
                      },
                    dataType: 'json',
                    success: function(data){
                      $('#department_id').html(data);                      
                    }
                  });
                }
          });  

          (function getHolidays()
          {
            var employee_id = "{{$employee->id}}";
            
              $.ajax({
                type:'POST',
                url:'{{route("getHolidaysSelected")}}',
                data: {
                    _method       : 'PUT',
                    employee_id   : employee_id,
                    _token        : '{{ csrf_token() }}'
                  },
                dataType:'json',
                success:function(data){
                  $('#holiday_id').html(data);
                }
              });
          }());  

          (function getDocumets()
          {
            var employee_id = "{{$employee->id}}";
            
              $.ajax({
                type:'POST',
                url:'{{route("getDocumentsSelected")}}',
                data: {
                    _method       : 'PUT',
                    employee_id   : employee_id,
                    _token        : '{{ csrf_token() }}'
                  },
                dataType:'json',
                success:function(data){
                  $('#document_id').html(data);
                }
              });
          }());  

          (function getSkills()
          {
            var employee_id = "{{$employee->id}}";
            
              $.ajax({
                type:'POST',
                url:'{{route("getSkillsSelected")}}',
                data: {
                    _method       : 'PUT',
                    employee_id   : employee_id,
                    _token        : '{{ csrf_token() }}'
                  },
                dataType:'json',
                success:function(data){
                  $('#skill_id').html(data);
                }
              });
          }());                             
    </script>
@endsection