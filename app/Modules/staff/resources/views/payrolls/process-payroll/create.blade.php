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
            <li class="breadcrumb-item"><a href="{{route('payroll-process.index')}}">{{ trans('staff::local.process_payroll') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('payroll-process.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                      <div class="col-lg-3 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('staff::local.payroll_sheet_name') }}</label> <br>
                            <select name="payroll_sheet_id" class="form-control" required>
                                <option value="">{{ trans('staff::local.select') }}</option>
                                @foreach ($payrollSheets as $payrollSheet)
                                    <option {{old('payroll_sheet_id') == $payrollSheet->id ? 'selected' :''}} value="{{$payrollSheet->id}}">
                                          {{session('lang') == 'ar' ? $payrollSheet->ar_sheet_name : $payrollSheet->en_sheet_name}}                                  
                                    </option>
                                @endforeach
                            </select> <br>
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                          </div>
                      </div>   
                      <div class="col-lg-2 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('staff::local.payroll_from_date') }}</label>
                            <input type="date" class="form-control" name="from_date">                            
                          </div>
                      </div>                                                                          
                      <div class="col-lg-2 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('staff::local.payroll_to_date') }}</label>
                          <input type="date" class="form-control" name="to_date">                          
                        </div>
                    </div> 
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('payroll-process.index')}}';">
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
        <div class="card-header">
          <h4 class="card-title">{{ trans('staff::local.employee_no_payroll') }}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-body card-dashboard">
            <div class="table-responsive">                
                  <table id="dynamic-table" class="table data-table" >
                      <thead class="bg-info white">
                          <tr>                              
                              <th>#</th>
                              <th>{{trans('staff::local.employee_image')}}</th>
                              <th>{{trans('staff::local.attendance_id')}}</th>                                
                              <th>{{trans('staff::local.employee_name')}}</th>                              
                              <th>{{trans('staff::local.hiring_date')}}</th>                              
                              <th>{{trans('staff::local.working_data')}}</th>
                              <th>{{trans('staff::local.position')}}</th>                              
                          </tr>
                      </thead>
                      <tbody>
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
     $(function () {
        var myTable = $('#dynamic-table').DataTable({
          processing: true,
          serverSide: false,
          "paging": true,
          "ordering": true,
          "info":     true,
          "pageLength": 10, // set page records
          "lengthMenu": [10,20, 50, 100, 200,500],
          "bLengthChange" : true,                   
          ajax: "{{ route('payroll-process.create') }}",
          columns: [              
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'employee_image',      name: 'employee_image'},              
              {data: 'attendance_id',       name: 'attendance_id'},              
              {data: 'employee_name',       name: 'employee_name'},              
              {data: 'hiring_date',         name: 'hiring_date'},              
              {data: 'working_data',        name: 'working_data'},
              {data: 'position',            name: 'position'},              
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
</script>
@include('layouts.backEnd.includes.datatables._multiSelect')
});
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
