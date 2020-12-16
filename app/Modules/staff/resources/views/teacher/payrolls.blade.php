@extends('layouts.backEnd.teacher')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ trans('staff::local.my_salries') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">{{ trans('staff::local.my_salries') }}
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
                                        <th>{{ trans('staff::local.payroll_sheet_name') }}</th>
                                        <th>{{ trans('staff::local.month') }}</th>
                                        <th>{{ trans('staff::local.from') }}</th>
                                        <th>{{ trans('staff::local.to') }}</th>
                                        <th>{{ trans('staff::local.salary') }}</th>
                                        <th>{{ trans('staff::local.salary_slip') }}</th>
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
@include('staff::teacher.includes._salary-slip')
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
                    url: '{{ route("payroll-process.profile") }}',
                    data: {
                        _method: 'PUT',
                        employee_id: employee_id,
                        _token: '{{ csrf_token() }}'
                    }
                },
                // columns
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'payrollSheet',
                        name: 'payrollSheet'
                    },
                    {
                        data: 'period',
                        name: 'period'
                    },
                    {
                        data: 'from_date',
                        name: 'from_date'
                    },
                    {
                        data: 'to_date',
                        name: 'to_date'
                    },
                    {
                        data: 'value',
                        name: 'value'
                    },
                    {
                        data: 'salary_slip',
                        name: 'salary_slip'
                    },
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')
        });

        function salarySlip(code, employee_id)
        {
          $.ajax({
            type: 'POST',
            url: '{{ route("teacher.salary-slip") }}',
            data: {
                _method: 'PUT',
                code: code,
                employee_id: employee_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data){
              $('#salary_slip').html(data);
                $('#salary-slip-modal').modal('show');              
            }
          })
        }

    </script>
    @include('layouts.backEnd.includes.datatables._datatable')
@endsection
