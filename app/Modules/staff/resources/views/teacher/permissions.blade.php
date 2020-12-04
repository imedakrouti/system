@extends('layouts.backEnd.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{ trans('staff::local.my_permssions') }}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">                 
            <li class="breadcrumb-item active">{{ trans('staff::local.my_permssions') }}
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
            <div class="table-responsive">
                <table id="dynamic-table" class="table data-table" style="width: 100%">
                    <thead class="bg-info white">
                        <tr>                              
                            <th>#</th>                              
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
                $('#dynamic-table').DataTable().destroy();            
                var employee_id = "{{authInfo()->employeeUser->id}}"
                
                var myTable = $('#dynamic-table').DataTable({
                "info":     true,              
                "bLengthChange" : false,          
                "pageLength": 10, // set page records
                ajax:{
                    type:'POST',
                    url:'{{route("leave-permissions.profile")}}',
                    data: {
                        _method       : 'PUT',
                        employee_id   : employee_id,                                      
                        _token        : '{{ csrf_token() }}'
                    }
                    },
                    // columns
                    columns: [                    
                        {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                        {data: 'date_leave',          name: 'date_leave'},                             
                        {data: 'time_leave',          name: 'time_leave'}, 
                        {data: 'leave_permission_id', name: 'leave_permission_id'},                                                                         
                        {data: 'approval1',           name: 'approval1'},                                           
                        {data: 'approval2',           name: 'approval2'},                                           
                        {data: 'updated_at',          name: 'updated_at'},                     
                    ],
                    @include('layouts.backEnd.includes.datatables._datatableLang')
                });
                @include('layouts.backEnd.includes.datatables._multiSelect')  
             });
    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection