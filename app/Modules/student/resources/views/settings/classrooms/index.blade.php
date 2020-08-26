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
          @include('student::settings.classrooms._filter')
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
                                <th>{{trans('student::local.ar_name_classroom')}}</th>                                
                                <th>{{trans('student::local.en_name_classroom')}}</th>
                                <th>{{trans('student::local.grade')}}</th>
                                <th>{{trans('student::local.division')}}</th>
                                <th>{{trans('student::local.year')}}</th>
                                <th>{{trans('student::local.sort')}}</th>
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
            dom: 'Bfrtip',
            buttons: [
                // new btn
                {
                    "text": "{{trans('student::local.new_classroom')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('classrooms.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'classrooms.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('classrooms.index') }}",
          columns: [
              {data: 'check',                   name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',             name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'ar_name_classroom',       name: 'ar_name_classroom'},
              {data: 'en_name_classroom',       name: 'en_name_classroom'},
              {data: 'grade_id',                name: 'grade_id'},              
              {data: 'division_id',             name: 'division_id'},              
              {data: 'year_id',                 name: 'year_id'},              
              {data: 'sort',                    name: 'sort'},              
              {data: 'action', 	                name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

    $('#division_id').on('change',function(){
      filter();
    });
    $('#grade_id').on('change',function(){
      filter();
    });
    $('#year_id').on('change',function(){
      filter();
    });
    $('#filter').on('click',function(){
      filter();
    });
    function filter()
    {
      $('#dynamic-table').DataTable().destroy();
      var grade_id 		= $('#grade_id').val();
      var division_id = $('#division_id').val();
      var year_id 		= $('#year_id').val();
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')
            dom: 'Bfrtip',
            buttons: [
                // new btn
                {
                    "text": "{{trans('student::local.new_classroom')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('classrooms.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'documents-grades.destroy'])              
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')              
            ],
            ajax:{
                type:'POST',
                url:'{{route("classrooms.filter")}}',
                data: {
                    _method     : 'PUT',
                    grade_id    : grade_id,
                    division_id : division_id,
                    year_id     : year_id,
                    _token      : '{{ csrf_token() }}'
                }
              },
          columns: [
            {data: 'check',                   name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',             name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'ar_name_classroom',       name: 'ar_name_classroom'},
              {data: 'en_name_classroom',       name: 'en_name_classroom'},
              {data: 'grade_id',                name: 'grade_id'},              
              {data: 'division_id',             name: 'division_id'},              
              {data: 'year_id',                 name: 'year_id'},              
              {data: 'sort',                    name: 'sort'},              
              {data: 'action', 	                name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    }
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection