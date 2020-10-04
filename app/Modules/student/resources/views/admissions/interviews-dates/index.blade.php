@extends('layouts.backEnd.cpanel')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/calendars/fullcalendar.min.css')}}">
@endsection
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
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
                    <div class="table-responsive">
                        <form action="" id='formData' method="post">
                            @csrf
                            <table id="dynamic-table" class="table data-table" style="width: 100%">
                                <thead class="bg-info white">
                                    <tr>
                                        <th><input type="checkbox" class="ace" /></th>
                                        <th>#</th>
                                        <th>{{trans('student::local.father_name')}}</th>
                                        <th>{{trans('student::local.start_time')}}</th>                                                
                                        <th>{{trans('student::local.end_time')}}</th>                                                
                                        <th>{{trans('student::local.type_interview')}}</th>
                                        <th>{{trans('student::local.status')}}</th>
                                        <th>{{trans('student::local.edit')}}</th>
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
                    "text": "{{trans('student::local.new_meeting')}}",
                    "className": "btn btn-success btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('meetings.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'meetings.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn'),
                // attend
                {
                    "text": "{{trans('student::local.meeting_done')}}",
                    "className": "btn btn-success btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                      event.preventDefault();
                      var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                      if (itemChecked > 0) {
                        var form_data = $('#formData').serialize();
                        swal({
                            title: "{{trans('student::local.confirm_father_attend')}}",
                            text: "{{trans('student::local.fathers_attend')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('father.attend')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    beforeSend:function(){
                                        $('.alert-danger ul').empty();
                                        $('.alert-danger').hide();
                                    },
                                    // display succees message
                                    success:function(data)
                                    {
                                        $('.alert-danger').hide();
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    },
                                    // display validations error in page
                                    error:function(data_error,exception){
                                        if (exception == 'error'){
                                            $('.alert-danger').show();
                                            $.each(data_error.responseJSON.errors,function(index,value){
                                                $('.alert-danger ul').append("<li>"+ value +"</li>");
                                            })
                                        }
                                        else{
                                            $('.alert-danger').hide();
                                        }
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('student::local.meetings')}}", "success");
                                })
                                // display error message
                                .error(function(data) {
                                    swal("{{trans('msg.error')}}", "{{trans('msg.fail')}}");
                                });
                            }
                        );
                      }else{
                          swal("{{trans('student::local.meeting_confirm')}}", "{{trans('msg.no_records_selected')}}", "info");
                      }                      
                     }
                },                  
                // pending
                {
                    "text": "{{trans('student::local.meeting_pending')}}",
                    "className": "btn btn-warning btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                      var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                      if (itemChecked > 0) {
                        var form_data = $('#formData').serialize();
                        swal({
                            title: "{{trans('student::local.confirm_father_pending')}}",
                            text: "{{trans('student::local.fathers_pending')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('father.pending')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    beforeSend:function(){
                                        $('.alert-danger ul').empty();
                                        $('.alert-danger').hide();
                                    },
                                    // display succees message
                                    success:function(data)
                                    {
                                        $('.alert-danger').hide();
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    },
                                    // display validations error in page
                                    error:function(data_error,exception){
                                        if (exception == 'error'){
                                            $('.alert-danger').show();
                                            $.each(data_error.responseJSON.errors,function(index,value){
                                                $('.alert-danger ul').append("<li>"+ value +"</li>");
                                            })
                                        }
                                        else{
                                            $('.alert-danger').hide();
                                        }
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('student::local.meetings')}}", "success");
                                })
                                // display error message
                                .error(function(data) {
                                    swal("{{trans('msg.error')}}", "{{trans('msg.fail')}}");
                                });
                            }
                        );
                      }else{
                          swal("{{trans('student::local.meeting_confirm')}}", "{{trans('msg.no_records_selected')}}", "info");
                      }                                     
                     }
                },
                // new btn
                {
                    "text": "{{trans('student::local.meeting_canceled')}}",
                    "className": "btn btn-danger btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                      var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                      if (itemChecked > 0) {
                        var form_data = $('#formData').serialize();
                        swal({
                            title: "{{trans('student::local.confirm_father_canceled')}}",
                            text: "{{trans('student::local.fathers_canceled')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('father.canceled')}}",
                                    method:"POST",
                                    data:form_data,
                                    dataType:"json",
                                    beforeSend:function(){
                                        $('.alert-danger ul').empty();
                                        $('.alert-danger').hide();
                                    },
                                    // display succees message
                                    success:function(data)
                                    {
                                        $('.alert-danger').hide();
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    },
                                    // display validations error in page
                                    error:function(data_error,exception){
                                        if (exception == 'error'){
                                            $('.alert-danger').show();
                                            $.each(data_error.responseJSON.errors,function(index,value){
                                                $('.alert-danger ul').append("<li>"+ value +"</li>");
                                            })
                                        }
                                        else{
                                            $('.alert-danger').hide();
                                        }
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {
                                    swal("{{trans('msg.success')}}", "{{trans('student::local.doneAccept')}}", "success");
                                })
                                // display error message
                                .error(function(data) {
                                    swal("{{trans('msg.error')}}", "{{trans('msg.fail')}}");
                                });
                            }
                        );
                      }else{
                          swal("{{trans('student::local.meeting_confirm')}}", "{{trans('msg.no_records_selected')}}", "info");
                      }                          
                    }
                },                                              
            ],
          ajax: "{{ route('meetings.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'father_name',         name: 'father_name'},
              {data: 'start',               name: 'start'},
              {data: 'end',                 name: 'end'}, 
              {data: 'meeting_status',      name: 'meeting_status'}, 
              {data: 'interview_id',        name: 'interview_id'}, 
              {data: 'action', 	            name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
</script>

@include('layouts.backEnd.includes.datatables._datatable')
@endsection

 