@extends('layouts.backEnd.teacher')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ trans('staff::local.my_deductions') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ trans('staff::local.my_deductions') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        @if (authInfo()->domain_role == trans('staff::local.super_visor'))
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="#" onclick="cancelDeduction()"
                        class="btn btn-info ml-1 box-shadow round">{{ trans('staff::local.cancel_deduction') }}</a>
                </div>
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="#" onclick="newDeduction()"
                        class="btn btn-success box-shadow round">{{ trans('staff::local.new_deduction') }}</a>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        @if (authInfo()->domain_role == trans('staff::local.super_visor'))
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                    <select class="form-control" id="deduction">
                                        <option value="{{ employee_id() }}">
                                            {{ trans('staff::local.me') }}
                                        </option>
                                        @foreach ($employees as $employee)
                                            <option {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                                value="{{ $employee->id }}">{{ $employee->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                        @endif
                        <div class="table-responsive">
                            <form action="" id='formData' method="post">
                              @csrf
                                <table id="dynamic-table" class="table data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="ace" /></th>
                                            <th>#</th>
                                            <th>{{ trans('staff::local.amount') }}</th>
                                            <th>{{ trans('staff::local.date_deduction') }}</th>
                                            <th>{{ trans('staff::local.approval1') }}</th>
                                            <th>{{ trans('staff::local.approval2') }}</th>
                                            <th>{{ trans('staff::local.deduction_updated_at') }}</th>
                                            <th>{{ trans('staff::local.reason') }}</th>
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
    @include('staff::teacher.includes._new-deduction')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            getData({{employee_id()}})

            $('#deduction').on('change', function() {
                var employee_id = $('#deduction').val();
                getData(employee_id);
            });

            function getData(employee_id) {
                $('#dynamic-table').DataTable().destroy();
                var myTable = $('#dynamic-table').DataTable({
                    "info": true,
                    "bLengthChange": false,
                    "pageLength": 10, // set page records            
                    "bLengthChange": true,
                    dom: 'blfrtip',
                    ajax: {
                        type: 'POST',
                        url: '{{ route("deductions.profile") }}',
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
                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'date_deduction',
                            name: 'date_deduction'
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
                        {
                            data: 'reason',
                            name: 'reason'
                        },
                    ],
                    @include('layouts.backEnd.includes.datatables._datatableLang')
                });
                @include('layouts.backEnd.includes.datatables._multiSelect')
            }
        })


        function reason(reason) {
            event.preventDefault();
            $('#reason_text').val(reason);
            $('#reason').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#reason').modal('show');
        }

        function newDeduction() {
            $('#new-deduction-modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#new-deduction-modal').modal('show');
        }

        // add new permission
        $('#deductionForm').on('submit', function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            swal({
                    title: "{{ trans('staff::local.confirm_save_deduction') }}",
                    text: "{{ trans('staff::local.ask_save_deduction') }}",
                    showCancelButton: true,
                    confirmButtonColor: "#87B87F",
                    confirmButtonText: "{{ trans('msg.yes') }}",
                    cancelButtonText: "{{ trans('msg.no') }}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url: "{{ route('teacher.store-deduction') }}",
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

                            $('#alert').addClass('hidden');

                            $('#deductionForm')[0].reset();
                            $('#dynamic-table').DataTable().ajax.reload();
                            swal("{{ trans('msg.success') }}",
                                "{{ trans('msg.stored_successfully') }}",
                                "success");
                            $('#new-deduction-modal').modal('hide');

                        }
                    })
                }
            );
        });

        function cancelDeduction() {
            var form_data = $('#formData').serialize();
            var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
            if (itemChecked == "0") {
                swal("{{ trans('staff::local.deductions') }}", "{{ trans('msg.no_records_selected') }}", "info");
                return;
            }
            swal({
                    title: "{{ trans('staff::local.deductions') }}",
                    text: "{{ trans('staff::local.deduction_cancel_confirm') }}",
                    showCancelButton: true,
                    confirmButtonColor: "#87B87F",
                    confirmButtonText: "{{ trans('msg.yes') }}",
                    cancelButtonText: "{{ trans('msg.no') }}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                            url: "{{ route('deductions.cancel') }}",
                            method: "POST",
                            data: form_data,
                            dataType: "json",
                            success: function(data) {
                                $('#dynamic-table').DataTable().ajax.reload();
                            }
                        })
                        // display success confirm message
                        .done(function(data) {
                            swal("{{ trans('msg.success') }}", "{{ trans('msg.updated_successfully') }}",
                            "success");
                        })
                }
            );
            // end swal           
        }

    </script>
    @include('layouts.backEnd.includes.datatables._datatable')
@endsection
