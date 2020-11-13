@extends('layouts.backEnd.dashboards.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{trans('staff::local.my_salries')}}</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <div class="table-responsive">
                <table id="dynamic-table" class="table data-table" style="width: 100%">
                    <thead class="bg-info white">
                        <tr>                              
                              <th>#</th>                              
                              <th>{{trans('staff::local.payroll_sheet_name')}}</th>
                              <th>{{trans('staff::local.month')}}</th>                                
                              <th>{{trans('staff::local.from')}}</th>                                
                              <th>{{trans('staff::local.to')}}</th>                                                                                                                       
                              <th>{{trans('staff::local.salary')}}</th>                                                                                                                       
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
                  url:'{{route("payroll-process.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'payrollSheet',        name: 'payrollSheet'},
                    {data: 'period',              name: 'period'},              
                    {data: 'from_date',           name: 'from_date'},               
                    {data: 'to_date',             name: 'to_date'},                
                    {data: 'value',               name: 'value'},                
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')  
             });
    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection