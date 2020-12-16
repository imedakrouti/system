@extends('layouts.backEnd.teacher')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
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
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <a href="#" onclick="cancelVacation()"
                    class="btn btn-info ml-1 box-shadow round">{{ trans('staff::local.cancel_vacation') }}</a>
            </div>
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a href="#" onclick="newPermission()" class="btn btn-success box-shadow round">{{ trans('staff::local.new_leave_permission') }}</a>
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
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="ace" /></th>
                                            <th>#</th>
                                            <th>{{ trans('staff::local.date_leave') }}</th>
                                            <th>{{ trans('staff::local.time_leave') }}</th>
                                            <th>{{ trans('staff::local.leave_permission_id') }}</th>
                                            <th>{{ trans('staff::local.approval1') }}</th>
                                            <th>{{ trans('staff::local.approval2') }}</th>
                                            <th>{{ trans('staff::local.loan_updated_at') }}</th>
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
@include('staff::teacher.includes._new-permssion')
@endsection
@section('script')
    <script>
        $(function() {
            $('#dynamic-table').DataTable().destroy();
            var employee_id = "{{ authInfo()->employeeUser->id }}"

            var myTable = $('#dynamic-table').DataTable({
                "info": true,
                "bLengthChange": false,
                "pageLength": 10, // set page records            
                "bLengthChange" : true,
                dom: 'blfrtip',
                ajax: {
                    type: 'POST',
                    url: '{{ route('leave-permissions.profile') }}',
                    data: {
                        _method: 'PUT',
                        employee_id: employee_id,
                        _token: '{{ csrf_token() }}'
                    }
                },
                // columns
                columns: [{
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false
                    },{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date_leave',
                        name: 'date_leave'
                    },
                    {
                        data: 'time_leave',
                        name: 'time_leave'
                    },
                    {
                        data: 'leave_permission_id',
                        name: 'leave_permission_id'
                    },
                    {
                        data: 'approval1',
                        name: 'approval1'
                    },
                    {
                        data: 'approval2',
                        name: 'approval2'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')
        });

         // add new permission
        $('#permissionForm').on('submit', function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            swal({
                    title: "{{ trans('staff::local.confirm_save_permission') }}",
                    text: "{{ trans('staff::local.ask_save_permission') }}",
                    showCancelButton: true,
                    confirmButtonColor: "#87B87F",
                    confirmButtonText: "{{ trans('msg.yes') }}",
                    cancelButtonText: "{{ trans('msg.no') }}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url: "{{ route('teacher.store-permission') }}",
                        method: "POST",
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        // display succees message
                        success: function(data) {
                            if (data.status == 'invalid_date') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            if (data.status == 'deny_day') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            if (data.status == 'no_enough_balance') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            if (data.status == 'no_department_found') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            if (data.status == 'no_balance_department') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            if (data.status == 'employee_has_current_permission') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            if (data.status == 'available_time') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }

                            $('#alert').addClass('hidden');

                            $('#permissionForm')[0].reset();
                            $('#dynamic-table').DataTable().ajax.reload();
                            swal("{{ trans('msg.success') }}", "{{ trans('msg.stored_successfully') }}",
                                "success");
                            $('#new-permission-modal').modal('hide');

                        }
                    })
                }
            );
        });

        function newPermission() 
        {
            $('#new-permission-modal').modal({backdrop: 'static', keyboard: false})
            $('#new-permission-modal').modal('show');
        }

        // cancel vacation
        function cancelVacation() {
            var form_data = $('#formData').serialize();
            var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
            if (itemChecked == "0") {
                swal("{{trans('staff::local.leave_permissions')}}", "{{trans('msg.no_records_selected')}}", "info");
                return;
            }
            swal({
                title: "{{trans('staff::local.leave_permissions')}}",
                text: "{{trans('staff::local.leave_permissions_cancel_confirm')}}",
                showCancelButton: true,
                confirmButtonColor: "#87B87F",
                confirmButtonText: "{{trans('msg.yes')}}",
                cancelButtonText: "{{trans('msg.no')}}",
                closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('leave-permissions.cancel')}}",
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

    </script>
    @include('layouts.backEnd.includes.datatables._datatable')
@endsection
