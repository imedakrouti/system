@extends('layouts.backEnd.cpanel')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
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
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>
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
          <form action="#" method="get" id="filterForm" >                
              <div class="row mt-1">  
                  <div class="col-lg-2 col-md-12">
                    <div class="form-group">
                      <select name="approval2" class="form-control" id="approval2">                            
                          <option value="">{{ trans('staff::local.select') }}</option>
                          <option value="Accepted">{{ trans('staff::local.accepted') }}</option>
                          <option value="Rejected">{{ trans('staff::local.rejected') }}</option>            
                          <option value="Canceled">{{ trans('staff::local.canceled') }}</option>            
                          <option value="Pending">{{ trans('staff::local.pending') }}</option>            
                      </select>
                    </div>
                  </div>    
                  <div class="col-lg-3 col-md-12">
                      <div class="form-group row">                          
                        <select name="employee_id" id="employee_id" class="form-control select2">
                            <option value="">{{ trans('staff::local.select') }}</option>
                            @foreach ($employees as $employee)
                                <option {{old('staff_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                                @if (session('lang') == 'ar')
                                [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                @else
                                [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$employee->en_th_name}}
                                @endif
                                </option>
                            @endforeach
                        </select> <br>
                        <span>{{ trans('staff::local.employee_name') }}</span>                                                      
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
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
              <div class="table-responsive">
                  <form action="" id='formData' method="post">
                    @csrf
                    <table id="dynamic-table" class="table data-table" >
                        <thead class="bg-info white">
                            <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('staff::local.attendance_id')}}</th>
                                <th>{{trans('staff::local.employee_name')}}</th>
                                <th>{{trans('staff::local.working_data')}}</th>                                                                
                                <th>{{trans('staff::local.date_leave')}}</th>                                                                
                                <th>{{trans('staff::local.time_leave')}}</th>                                                                                                   
                                <th>{{trans('staff::local.leave_permission_id')}}</th>                                                                                                   
                                <th>{{trans('staff::local.approval1')}}</th>                                                                                                
                                <th>{{trans('staff::local.approval2')}}</th>                                                                                                
                                <th>{{trans('staff::local.loan_updated_at')}}</th>                                                                                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </form>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')         
        @include('staff::leave-permissions.includes._buttons-confirm'),
          ajax: "{{ route('leave-permissions.confirm') }}",
          @include('staff::leave-permissions.includes._columns-confirm'),
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    $('#approval2').on('change',function(){
      $('#employee_id').val(null).trigger('change');
      $('#dynamic-table').DataTable().destroy();
      var approval2 		  = $('#approval2').val();
      
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        @include('staff::leave-permissions.includes._buttons-confirm'),
        ajax:{
            type:'POST',
            url:'{{route("leave-permissions.filter-confirm")}}',
            data: {
                _method       : 'PUT',
                approval2     : approval2,                
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          @include('staff::leave-permissions.includes._columns-confirm'),
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')        
    })  

    $('#employee_id').on('change',function(){
      
      $('#dynamic-table').DataTable().destroy();
      var approval2 		  = $('#approval2').val();
      var employee_id 		= $('#employee_id').val();
      
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        @include('staff::leave-permissions.includes._buttons-confirm'),
        ajax:{
            type:'POST',
            url:'{{route("leave-permissions.employee-confirm")}}',
            data: {
                _method       : 'PUT',
                employee_id   : employee_id,                
                approval2     : approval2,                
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          @include('staff::leave-permissions.includes._columns-confirm'),
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')        
    })      
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection