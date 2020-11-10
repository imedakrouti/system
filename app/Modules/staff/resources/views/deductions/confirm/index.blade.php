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
                  <div class="col-lg-3 col-md-6">
                      <select name="approval2" class="form-control" id="approval2">                            
                          <option value="">{{ trans('staff::local.select') }}</option>
                          <option value="Accepted">{{ trans('staff::local.accepted') }}</option>
                          <option value="Rejected">{{ trans('staff::local.rejected') }}</option>            
                          <option value="Canceled">{{ trans('staff::local.canceled') }}</option>            
                          <option value="Pending">{{ trans('staff::local.pending') }}</option>            
                      </select>
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
                                <th>{{trans('staff::local.position')}}</th>
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
                  </form>
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
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [ 
                 // new accepted
                {
                    "text": "{{trans('staff::local.accepted')}}",
                    "className": "btn btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                      var form_data = $('#formData').serialize();
                        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                        if (itemChecked == "0") {
                            swal("{{trans('staff::local.deductions')}}", "{{trans('msg.no_records_selected')}}", "info");
                            return;
                        }
                        swal({
                            title: "{{trans('staff::local.deductions')}}",
                            text: "{{trans('staff::local.deductions_accept_confirm')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('deductions.accept-confirm')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    success:function(data)
                                    {                                        
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('msg.updated_successfully')}}", "success");
                                })
                            }
                        );
                        // end swal                        
                    }
                },
                // new rejected
                {
                    "text": "{{trans('staff::local.rejected')}}",
                    "className": "btn btn-danger mr-1",
                    action : function ( e, dt, node, config ) {
                      var form_data = $('#formData').serialize();
                        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                        if (itemChecked == "0") {
                            swal("{{trans('staff::local.deductions')}}", "{{trans('msg.no_records_selected')}}", "info");
                            return;
                        }
                        swal({
                            title: "{{trans('staff::local.deductions')}}",
                            text: "{{trans('staff::local.deductions_reject_confirm')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('deductions.reject-confirm')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    success:function(data)
                                    {                                        
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('msg.updated_successfully')}}", "success");
                                })
                            }
                        );
                        // end swal                        
                    }
                },                 
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('deductions.confirm') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'attendance_id',       name: 'attendance_id'},
              {data: 'employee_name',       name: 'employee_name'},              
              {data: 'workingData',         name: 'workingData'},
              {data: 'position',            name: 'position'},              
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

    $('#approval2').on('change',function(){
      $('#dynamic-table').DataTable().destroy();
      var approval2 		  = $('#approval2').val();
      
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        buttons: [ 
                 // new accepted
                {
                    "text": "{{trans('staff::local.accepted')}}",
                    "className": "btn btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                      var form_data = $('#formData').serialize();
                        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                        if (itemChecked == "0") {
                            swal("{{trans('staff::local.deductions')}}", "{{trans('msg.no_records_selected')}}", "info");
                            return;
                        }
                        swal({
                            title: "{{trans('staff::local.deductions')}}",
                            text: "{{trans('staff::local.deductions_accept_confirm')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('deductions.accept-confirm')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    success:function(data)
                                    {                                        
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('msg.updated_successfully')}}", "success");
                                })
                            }
                        );
                        // end swal                        
                    }
                },
                // new rejected
                {
                    "text": "{{trans('staff::local.rejected')}}",
                    "className": "btn btn-danger mr-1",
                    action : function ( e, dt, node, config ) {
                      var form_data = $('#formData').serialize();
                        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                        if (itemChecked == "0") {
                            swal("{{trans('staff::local.deductions')}}", "{{trans('msg.no_records_selected')}}", "info");
                            return;
                        }
                        swal({
                            title: "{{trans('staff::local.deductions')}}",
                            text: "{{trans('staff::local.deductions_reject_confirm')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('deductions.reject-confirm')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    success:function(data)
                                    {                                        
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('msg.updated_successfully')}}", "success");
                                })
                            }
                        );
                        // end swal                        
                    }
                },                 
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
        ajax:{
            type:'POST',
            url:'{{route("deductions.filter-confirm")}}',
            data: {
                _method       : 'PUT',
                approval2     : approval2,                
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'attendance_id',       name: 'attendance_id'},
              {data: 'employee_name',       name: 'employee_name'},              
              {data: 'workingData',         name: 'workingData'},
              {data: 'position',            name: 'position'},              
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
    })  
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