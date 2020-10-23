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
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
          <form action="#" method="get" id="filterForm" >                
              <div class="row mt-1">                          
                  <div class="col-lg-3 col-md-6">
                      <select name="approval2" class="form-control" id="approval2">                            
                          <option value="">{{ trans('staff::local.status') }}</option>
                          <option value="Accepted">{{ trans('staff::local.accepted') }}</option>
                          <option value="Rejected">{{ trans('staff::local.rejected') }}</option>            
                          <option value="Canceled">{{ trans('staff::local.canceled') }}</option>            
                          <option value="Pending">{{ trans('staff::local.pending') }}</option>            
                      </select>
                  </div>   
                  <div class="col-lg-3 col-md-6">
                    <select name="vacation_type" class="form-control" id="vacation_type">                            
                        <option value="">{{ trans('staff::local.vacation_type') }}</option>
                        <option value="Start work">{{ trans('staff::local.start_work') }}</option>
                        <option value="End work">{{ trans('staff::local.end_work') }}</option>
                        <option value="Sick leave">{{ trans('staff::local.sick_leave') }}</option>
                        <option value="Regular vacation">{{ trans('staff::local.regular_vacation') }}</option>
                        <option value="Vacation without pay">{{ trans('staff::local.vacation_without_pay') }}</option>
                        <option value="Work errand">{{ trans('staff::local.work_errand') }}</option>
                        <option value="Training">{{ trans('staff::local.training') }}</option>
                        <option value="Casual vacation">{{ trans('staff::local.casual_vacation') }}</option>          
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
                                <th>{{ trans('staff::local.employee_image') }}</th>
                                <th>{{trans('staff::local.attendance_id')}}</th>
                                <th>{{trans('staff::local.employee_name')}}</th>                                
                                <th>{{trans('staff::local.vacation_type')}}</th>                                
                                <th>{{trans('staff::local.date_vacation')}}</th>                                                                
                                <th>{{trans('staff::local.vacation_period')}}</th>
                                <th>{{trans('staff::local.vacation_days')}}</th>                                                                
                                <th>{{trans('staff::local.approval2')}}</th>                                                                                                
                                <th>{{trans('staff::local.attachments')}}</th>                                                                                                
                                <th>{{trans('staff::local.vacation_updated_at')}}</th>                                                                                                                                
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
                 // new accepted
                {
                    "text": "{{trans('staff::local.accepted')}}",
                    "className": "btn btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                      var form_data = $('#formData').serialize();
                        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                        if (itemChecked == "0") {
                            swal("{{trans('staff::local.vacations')}}", "{{trans('msg.no_records_selected')}}", "info");
                            return;
                        }
                        swal({
                            title: "{{trans('staff::local.vacations')}}",
                            text: "{{trans('staff::local.vacations_accept_confirm')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('vacations.accept-confirm')}}",
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
                                    if (data.status == true) {
                                        swal("{{trans('msg.success')}}", data.msg, "success");    
                                    } else {
                                        swal("{{trans('msg.error')}}", data.msg, "error");
                                    }
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
                            swal("{{trans('staff::local.vacations')}}", "{{trans('msg.no_records_selected')}}", "info");
                            return;
                        }
                        swal({
                            title: "{{trans('staff::local.vacations')}}",
                            text: "{{trans('staff::local.vacations_reject_confirm')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('vacations.reject-confirm')}}",
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
                                    if (data.status == true) {
                                        swal("{{trans('msg.success')}}", data.msg, "success");    
                                    } else {
                                        swal("{{trans('msg.error')}}", data.msg, "error");
                                    }
                                })
                            }
                        );
                        // end swal                        
                    }
                },                 
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('vacations.confirm') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'employee_image',      name: 'employee_image'},
              {data: 'attendance_id',       name: 'attendance_id'},
              {data: 'employee_name',       name: 'employee_name'},                            
              {data: 'vacation_type',       name: 'vacation_type'},
              {data: 'date_vacation',       name: 'date_vacation'},                             
              {data: 'vacation_period',     name: 'vacation_period'},              
              {data: 'count',               name: 'count'},                             
              {data: 'approval2',           name: 'approval2'},                                           
              {data: 'attachments',         name: 'attachments'},                                             
              {data: 'updated_at',          name: 'updated_at'},                                                         
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    $('#approval2').on('change',function(){
        filter();
    })  
    $('#vacation_type').on('change',function(){
        filter();
    })
    function filter()
    {
        $('#dynamic-table').DataTable().destroy();
        var approval2 		  = $('#approval2').val();
        var vacation_type 	  = $('#vacation_type').val();
        
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
                                swal("{{trans('staff::local.vacations')}}", "{{trans('msg.no_records_selected')}}", "info");
                                return;
                            }
                            swal({
                                title: "{{trans('staff::local.vacations')}}",
                                text: "{{trans('staff::local.vacations_accept_confirm')}}",
                                showCancelButton: true,
                                confirmButtonColor: "#87B87F",
                                confirmButtonText: "{{trans('msg.yes')}}",
                                cancelButtonText: "{{trans('msg.no')}}",
                                closeOnConfirm: false,
                                },
                                function() {
                                    $.ajax({
                                        url:"{{route('vacations.accept-confirm')}}",
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
                                        if (data.status == true) {
                                        swal("{{trans('msg.success')}}", data.msg, "success");    
                                    } else {
                                        swal("{{trans('msg.error')}}", data.msg, "error");
                                    }
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
                                swal("{{trans('staff::local.vacations')}}", "{{trans('msg.no_records_selected')}}", "info");
                                return;
                            }
                            swal({
                                title: "{{trans('staff::local.vacations')}}",
                                text: "{{trans('staff::local.vacations_reject_confirm')}}",
                                showCancelButton: true,
                                confirmButtonColor: "#87B87F",
                                confirmButtonText: "{{trans('msg.yes')}}",
                                cancelButtonText: "{{trans('msg.no')}}",
                                closeOnConfirm: false,
                                },
                                function() {
                                    $.ajax({
                                        url:"{{route('vacations.reject-confirm')}}",
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
                                        if (data.status == true) {
                                        swal("{{trans('msg.success')}}", data.msg, "success");    
                                    } else {
                                        swal("{{trans('msg.error')}}", data.msg, "error");
                                    }
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
                url:'{{route("vacations.filter-confirm")}}',
                data: {
                    _method       : 'PUT',
                    approval2     : approval2,                
                    vacation_type : vacation_type,                
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
                {data: 'vacation_type',       name: 'vacation_type'},                             
                {data: 'date_vacation',       name: 'date_vacation'},                             
                {data: 'vacation_period',     name: 'vacation_period'},              
                {data: 'count',               name: 'count'},                               
                {data: 'approval2',           name: 'approval2'},                                           
                {data: 'attachments',         name: 'attachments'},                                             
                {data: 'updated_at',          name: 'updated_at'},   
                
            ],
            @include('layouts.backEnd.includes.datatables._datatableLang')
        });
        @include('layouts.backEnd.includes.datatables._multiSelect')  
    }
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection