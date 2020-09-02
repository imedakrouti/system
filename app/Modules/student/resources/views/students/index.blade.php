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
                                <th>{{trans('student::local.student_image')}}</th>
                                <th>{{trans('student::local.application_date')}}</th>                                                                
                                <th>{{trans('student::local.student_name')}}</th>
                                <th>{{trans('student::local.student_type')}}</th>
                                <th>{{trans('student::local.registration_status')}}</th>
                                <th>{{trans('student::local.religion')}}</th>
                                <th>{{trans('student::local.grade')}}</th>
                                <th>{{trans('student::local.division')}}</th>                                
                                <th>{{trans('student::local.more')}}</th>                                                                
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
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'students.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('students.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'studentImage',        name: 'studentImage'},
              {data: 'application_date',    name: 'application_date'},
              {data: 'studentName',         name: 'studentName'},
              {data: 'student_type',        name: 'student_type'},
              {data: 'registration_status', name: 'registration_status'},
              {data: 'religion',            name: 'religion'},              
              {data: 'grade',               name: 'grade'},
              {data: 'division',            name: 'division'},              
              {data: 'moreBtn',             name: 'moreBtn', orderable: false, searchable: false},                            
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
