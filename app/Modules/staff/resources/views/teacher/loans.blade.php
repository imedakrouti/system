@extends('layouts.backEnd.teacher')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ trans('staff::local.my_loans') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ trans('staff::local.my_loans') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <a href="#" onclick="cancelLoan()"
                    class="btn btn-info ml-1 box-shadow round">{{ trans('staff::local.cancel_loan') }}
                </a>
            </div>
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <a href="#" onclick="newLoan()"
                    class="btn btn-success box-shadow round">{{ trans('staff::local.ask_loan') }}
                </a>
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
                                            <th>{{ trans('staff::local.amount') }}</th>
                                            <th>{{ trans('staff::local.date_loan') }}</th>
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
    @include('staff::teacher.includes._new-loan')
@endsection
@section('script')
    <script>
        $(function() {
            var employee_id = "{{ authInfo()->employeeUser->id }}"
            $('#dynamic-table').DataTable().destroy();
            var myTable = $('#dynamic-table').DataTable({
                "info": true,
                "bLengthChange": false,
                "pageLength": 10, // set page records            
                "bLengthChange": true,
                dom: 'blfrtip',
                ajax: {
                    type: 'POST',
                    url: '{{ route("loans.profile") }}',
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
                    }, {
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
                        data: 'date_loan',
                        name: 'date_loan'
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

        function newLoan() {
            $('#new-loan-modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#new-loan-modal').modal('show');
        }

        // add new loan
        $('#loanForm').on('submit', function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            swal({
                    title: "{{ trans('staff::local.confirm_save_loan') }}",
                    text: "{{ trans('staff::local.ask_save_loan') }}",
                    showCancelButton: true,
                    confirmButtonColor: "#87B87F",
                    confirmButtonText: "{{ trans('msg.yes') }}",
                    cancelButtonText: "{{ trans('msg.no') }}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url: "{{ route('teacher.store-loan') }}",
                        method: "POST",
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        // display succees message
                        success: function(data) {
                            if (data.status == 'invalid') {
                                $('#alert').removeClass('hidden');
                                $('#msg').html(data.msg);
                                return;
                            }
                            $('#alert').addClass('hidden');

                            $('#loanForm')[0].reset();
                            $('#dynamic-table').DataTable().ajax.reload();
                            swal("{{ trans('msg.success') }}",
                                "{{ trans('msg.stored_successfully') }}",
                                "success");
                            $('#new-loan-modal').modal('hide');
                        }
                    })
                }
            );
        });

        function cancelLoan() {
            var form_data = $('#formData').serialize();
            var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
            if (itemChecked == "0") {
                swal("{{ trans('staff::local.loans') }}", "{{ trans('msg.no_records_selected') }}", "info");
                return;
            }
            swal({
                    title: "{{ trans('staff::local.loans') }}",
                    text: "{{ trans('staff::local.loans_cancel_confirm') }}",
                    showCancelButton: true,
                    confirmButtonColor: "#87B87F",
                    confirmButtonText: "{{ trans('msg.yes') }}",
                    cancelButtonText: "{{ trans('msg.no') }}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                            url: "{{ route('loans.cancel') }}",
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
