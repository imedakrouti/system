@extends('layouts.backEnd.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title">{{ trans('staff::local.my_vacation') }}</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">                 
          <li class="breadcrumb-item active">{{ trans('staff::local.my_vacation') }}
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
                    <thead>
                        <tr>                              
                              <th>#</th>                              
                              <th>{{trans('staff::local.vacation_type')}}</th>                                                              
                              <th>{{trans('staff::local.vacation_period')}}</th>
                              <th>{{trans('staff::local.vacation_days')}}</th>                                                                
                              <th>{{trans('staff::local.approval1')}}</th>                                                                                                
                              <th>{{trans('staff::local.approval2')}}</th>                                                                                                
                              <th>{{trans('staff::local.attachments')}}</th>                                                                                                
                              <th>{{trans('staff::local.vacation_updated_at')}}</th>                                                                                                                                 
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
                var employee_id = "{{authInfo()->employeeUser->id}}"             
                $('#dynamic-table').DataTable().destroy();            
                var myTable = $('#dynamic-table').DataTable({
              "info":     true,              
              "bLengthChange" : false,          
              "pageLength": 5, // set page records
              ajax:{
                  type:'POST',
                  url:'{{route("vacations.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'vacation_type',       name: 'vacation_type'},                                                 
                    {data: 'vacation_period',     name: 'vacation_period'},              
                    {data: 'count',               name: 'count'},                               
                    {data: 'approval1',           name: 'approval1'},                                           
                    {data: 'approval2',           name: 'approval2'},                                           
                    {data: 'attachments',         name: 'attachments'},                                                                                  
                    {data: 'updated_at',          name: 'updated_at'},                      
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')  
             });
    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection