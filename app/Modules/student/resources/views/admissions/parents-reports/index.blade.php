@extends('layouts.backEnd.cpanel')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('public/cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
                              <th>{{trans('student::local.report_title')}}</th>
                              <th>{{trans('student::local.father_name')}}</th>
                              <th>{{trans('student::local.created_by')}}</th>                                                                
                              <th>{{trans('student::local.created_at')}}</th>
                              <th>{{trans('student::local.updated_at')}}</th>                                                              
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
                  "text": "{{trans('student::local.add_parent_report')}}",
                  "className": "btn btn-success buttons-print btn-success mr-1",
                  action : function ( e, dt, node, config ) {
                      window.location.href = "{{route('parent-reports.create')}}";
                      }
              },            
              // delete btn
              @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'parent-reports.destroy'])

              // default btns
              @include('layouts.backEnd.includes.datatables._datatableBtn')
          ],
        ajax: "{{ route('parent-reports.index') }}",
        columns: [
            {data: 'check',               name: 'check', orderable: false, searchable: false},
            {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'report_title',        name: 'report_title'},
            {data: 'father_name',         name: 'father_name'},
            {data: 'created_by',          name: 'created_by'},
            {data: 'created_at',          name: 'created_at'},
            {data: 'updated_at',          name: 'updated_at'},                                     
        ],
        @include('layouts.backEnd.includes.datatables._datatableLang')
    });
    @include('layouts.backEnd.includes.datatables._multiSelect')
  });
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection

