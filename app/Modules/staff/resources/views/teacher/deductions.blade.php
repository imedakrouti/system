@extends('layouts.backEnd.dashboards.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{trans('staff::local.my_deductions')}}</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <div class="table-responsive">
                <table id="dynamic-table" class="table data-table" style="width: 100%">
                    <thead class="bg-info white">
                        <tr>                              
                            <th>#</th>                              
                            <th>{{trans('staff::local.amount')}}</th>                                
                            <th>{{trans('staff::local.date_deduction')}}</th>                                                                
                            <th>{{trans('staff::local.approval1')}}</th>                                                                                                
                            <th>{{trans('staff::local.approval2')}}</th>                                                                                                                              
                            <th>{{trans('staff::local.deduction_updated_at')}}</th>                                                                                                
                            <th>{{trans('staff::local.reason')}}</th>                                                                                                                              
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
@include('staff::deductions.includes._reason')
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
                  url:'{{route("deductions.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'amount',              name: 'amount'},               
                    {data: 'date_deduction',      name: 'date_deduction'},                             
                    {data: 'approval1',           name: 'approval1'},                                           
                    {data: 'approval2',           name: 'approval2'},                                                               
                    {data: 'updated_at',          name: 'updated_at'},  
                    {data: 'reason',              name: 'reason'},                     
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')  
        });
        function reason(reason)
          {
              event.preventDefault();          
              $('#reason_text').val(reason);			
              $('#reason').modal({backdrop: 'static', keyboard: false})
              $('#reason').modal('show');
          }    

    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection