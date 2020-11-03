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
                                <th>{{trans('staff::local.payroll_sheet_name')}}</th>
                                <th>{{trans('staff::local.month')}}</th>                                
                                <th>{{trans('staff::local.from')}}</th>                                
                                <th>{{trans('staff::local.to')}}</th>                                
                                <th>{{trans('staff::local.total_employees')}}</th>
                                <th>{{trans('staff::local.total_payroll')}}</th>
                                <th>{{trans('admin.username')}}</th>
                                <th>{{trans('staff::local.confirm')}}</th>
                                <th>{{trans('staff::local.reports')}}</th>
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

@include('staff::payrolls.process-payroll.includes._department-reports')
@endsection
@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                // new btn
                {
                    "text": "{{trans('staff::local.process_payroll')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('payroll-process.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'payroll-process.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('payroll-process.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'payrollSheet',        name: 'payrollSheet'},
              {data: 'period',              name: 'period'},              
              {data: 'from_date',           name: 'from_date'},               
              {data: 'to_date',             name: 'to_date'},               
              {data: 'total_employees',     name: 'total_employees'},               
              {data: 'total_Payroll',       name: 'total_Payroll'},               
              {data: 'username',            name: 'username'},               
              {data: 'confirm',             name: 'confirm'},               
              {data: 'reports',             name: 'reports'},               
              
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    function departmentReport(code)
    {
      $('#code').val(code);
      $('#departmentReport').modal({backdrop: 'static', keyboard: false})
      $('#departmentReport').modal('show');   
    }
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
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection