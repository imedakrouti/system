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
                  <div class="col-lg-3 col-md-12">
                      <select name="payroll_sheet_id" class="form-control" id="payroll_sheet_id">
                          <option value="">{{ trans('staff::local.payrolls_sheets') }}</option>
                          @foreach ($payrollSheets as $payrollSheet)
                              <option {{old('payroll_sheet_id') == $payrollSheet->id ? 'selected' :''}} value="{{$payrollSheet->id}}">
                                    {{session('lang') == 'ar' ? $payrollSheet->ar_sheet_name : $payrollSheet->en_sheet_name}}                                  
                              </option>
                          @endforeach
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
                                <th>{{trans('staff::local.payroll_sheet_name')}}</th>
                                <th>{{trans('staff::local.ar_item')}}</th>
                                <th>{{trans('staff::local.en_item')}}</th>                                    
                                <th>{{trans('staff::local.type')}}</th>                                
                                <th>{{trans('staff::local.registration')}}</th>                                
                                <th>{{trans('staff::local.calculate')}}</th>                                
                                <th>{{trans('staff::local.sort')}}</th>                                
                                <th>{{trans('staff::local.edit')}}</th>
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
                    "text": "{{trans('staff::local.new_salary_component')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('salary-components.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'salary-components.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('salary-components.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'payroll_sheet_name',  name: 'payroll_sheet_name'},
              {data: 'ar_item',             name: 'ar_item'},
              {data: 'en_item',             name: 'en_item'},                  
              {data: 'type',                name: 'type'},               
              {data: 'registration',        name: 'registration'},               
              {data: 'calculate',           name: 'calculate'},               
              {data: 'sort',                name: 'sort'},               
              {data: 'action', 	            name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    $('#payroll_sheet_id').on('change',function(){
      $('#dynamic-table').DataTable().destroy();
      var payroll_sheet_id 		  = $('#payroll_sheet_id').val();
      
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        buttons: [
                // new btn
                {
                    "text": "{{trans('staff::local.new_salary_component')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('salary-components.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'salary-components.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
        ajax:{
            type:'POST',
            url:'{{route("salary-components.filter")}}',
            data: {
                _method       : 'PUT',
                payroll_sheet_id     : payroll_sheet_id,                
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'payroll_sheet_name',  name: 'payroll_sheet_name'},
              {data: 'ar_item',             name: 'ar_item'},
              {data: 'en_item',             name: 'en_item'},                  
              {data: 'type',                name: 'type'},               
              {data: 'registration',        name: 'registration'},               
              {data: 'calculate',           name: 'calculate'},               
              {data: 'sort',                name: 'sort'},               
              {data: 'action', 	            name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')        
    })
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection