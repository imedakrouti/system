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

@include('staff::employees.includes._filter')


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
                                <th>{{trans('staff::local.employee_image')}}</th>
                                <th>{{trans('staff::local.attendance_id')}}</th>                                
                                <th>{{trans('staff::local.employee_name')}}</th>
                                <th>{{trans('staff::local.mobile')}}</th>
                                <th>{{trans('staff::local.working_data')}}</th>
                                <th>{{trans('staff::local.position')}}</th>
                                <th>{{trans('staff::local.reports')}}</th>
                                <th>{{trans('staff::local.edit')}}</th>
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
            buttons: [
                // new btn
                {
                    "text": "{{trans('staff::local.new_employee')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('employees.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'employees.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('employees.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'employee_image',      name: 'employee_image'},              
              {data: 'attendance_id',       name: 'attendance_id'},              
              {data: 'employee_name',       name: 'employee_name'},
              {data: 'mobile',              name: 'mobile'},
              {data: 'working_data',        name: 'working_data'},
              {data: 'position',            name: 'position'},
              {data: 'reports',             name: 'reports'},
              {data: 'action', 	            name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    function filter()
    {
      event.preventDefault();
      $('#dynamic-table').DataTable().destroy();
      var sector_id 		  = $('#filter_sector_id').val();
      var department_id   = $('#filter_department_id').val();
      var section_id 		  = $('#filter_section_id').val();
      var position_id     = $('#filter_position_id').val();
      var leaved 	        = $('#filter_leaved').val();
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        buttons: [
                // new btn
                {
                    "text": "{{trans('staff::local.new_employee')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('employees.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'employees.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
        ajax:{
            type:'POST',
            url:'{{route("employees.filter")}}',
            data: {
                _method       : 'PUT',
                sector_id     : sector_id,
                section_id    : section_id,
                department_id : department_id,                            
                position_id   : position_id,
                leaved        : leaved,
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'employee_image',      name: 'employee_image'},              
              {data: 'attendance_id',       name: 'attendance_id'},              
              {data: 'employee_name',       name: 'employee_name'},
              {data: 'mobile',              name: 'mobile'},
              {data: 'working_data',        name: 'working_data'},
              {data: 'position',            name: 'position'},
              {data: 'reports',             name: 'reports'},
              {data: 'action', 	            name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    }        
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection