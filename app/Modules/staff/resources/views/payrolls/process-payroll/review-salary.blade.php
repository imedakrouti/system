@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
          <div class="card-body card-dashboard">            
              <form action="{{route('attendances.report')}}" method="GET" target="blank" id="sheetReport">
                <div class="row">
                  <div class="col-lg-3 col-md-12">
                      <div class="form-group">                      
                        <select name="attendance_id" id="attendance_id" class="form-control select2" required>
                            <option value="">{{ trans('staff::local.employee_name') }}</option>
                            @foreach ($employees as $employee)
                                <option {{old('attendance_id') == $employee->id ? 'selected' :''}} value="{{$employee->attendance_id}}">
                                @if (session('lang') == 'ar')
                                [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                @else
                                [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$employee->en_th_name}}
                                @endif
                                </option>
                            @endforeach
                        </select> <br>                  
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="form-group">                        
                          <input type="date" class="form-control" name="from_date" id="from_date" required>                 
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="form-group">                        
                          <input type="date" class="form-control" name="to_date" id="to_date" required>                 
                      </div>
                  </div>
  
                  <div class="col-lg-2 col-md-6">
                      <div class="form-group">                           
                          <a href="#" class="btn btn-primary" onclick="reviewSalary()">{{ trans('staff::local.search') }}</a>
                      </div>
                  </div>
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
          <div class="card-body card-dashboard">
            <div class="table-responsive">
              <table class="table table-striped" >
                <thead class="bg-info white">
                    <tr class="center">                                                                                      
                          <th width="120px">{{trans('staff::local.salary_components')}}</th>
                          <th width="120px">{{trans('staff::local.value')}}</th>                                                                      
                    </tr>
                </thead>
                <tbody id="salary_details">
    
                </tbody>
            </table>            
            </div>                     
          </div>
        </div>
      </div>
    </div>
  </div>
  


@endsection
@section('script')
    <script>
        function reviewSalary()
        {
        var attendance_id   = $('#attendance_id').val();
        var from_date       = $('#from_date').val();
        var to_date         = $('#to_date').val();

        if (attendance_id == '') {
            swal("{{trans('staff::local.review_payroll')}}", "{{trans('staff::local.no_employee')}}", "error");
            return;
        }
        if (from_date == '' || to_date == '') {
            swal("{{trans('staff::local.review_payroll')}}", "{{trans('staff::local.invalid_dates_review')}}", "error");
            return;
        }
        
        $.ajax({
                url:'{{route("payroll-process.set-review")}}',
                type:"post",
                data: {
                _method		    : 'PUT',                
                attendance_id : attendance_id,
                from_date 	  : from_date,
                to_date 	    : to_date,
                _token		    : '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data){
                $('#salary_details').html(data);
                }
            });
        }        
    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
