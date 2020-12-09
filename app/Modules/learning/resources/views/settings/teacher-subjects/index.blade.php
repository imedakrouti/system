@extends('layouts.backEnd.cpanel')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
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
                    <table id="dynamic-table" class="table data-table" >
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('staff::local.employee_image')}}</th>                                
                                <th>{{trans('staff::local.attendance_id')}}</th>
                                <th>{{trans('staff::local.employee_name')}}</th>
                                <th>{{trans('learning::local.subject')}}</th>                                
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
                    "text": "{{trans('learning::local.add_teacher_subject')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('teacher-subjects.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'teacher-subjects.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('teacher-subjects.index') }}",
          columns: [
                {data: 'check',                 name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'employee_image',        name: 'employee_image'},
                {data: 'attendance_id',         name: 'attendance_id'},
                {data: 'employee_name',         name: 'employee_name'},
                {data: 'subjects',              name: 'subjects'},              
                
            ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection