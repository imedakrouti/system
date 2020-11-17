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
                                <th>{{trans('student::local.student_number')}}</th>                                                                
                                <th>{{trans('student::local.student_name')}}</th>                                                                
                                <th>{{trans('student::local.division')}}</th>                                                                
                                <th>{{trans('student::local.grade')}}</th>                                                                
                                <th>{{trans('learning::local.subjects')}}</th>                                
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
                    "text": "{{trans('learning::local.add_student_subject')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('student-subjects.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'student-subjects.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('student-subjects.index') }}",
          columns: [
                {data: 'check',                 name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},                                
                {data: 'student_number',        name: 'student_number'},
                {data: 'student_name',          name: 'student_name'},
                {data: 'division',              name: 'division'},
                {data: 'grade',                 name: 'grade'},
                {data: 'subjects',              name: 'subjects'},              
                
            ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection