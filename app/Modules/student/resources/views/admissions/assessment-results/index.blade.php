@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('public/cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
                <div class="card-body">
                    <div class="table-responsive">                               
                        <form action="" id='formData' method="post">
                        <table id="dynamic-table" class="table data-table" >
                            @csrf
                            <thead class="bg-info white">
                                <tr>
                                    <th><input type="checkbox" class="ace" /></th>
                                    <th>#</th>
                                    <th>{{trans('student::local.application_date')}}</th>
                                    <th>{{trans('student::local.student_number')}}</th>
                                    <th>{{trans('student::local.student_name')}}</th>
                                    <th>{{trans('student::local.student_type')}}</th>
                                    <th>{{trans('student::local.grade')}}</th>                              
                                    <th>{{trans('student::local.division')}}</th>                              
                                    <th>{{trans('student::local.assessment_type')}}</th>                              
                                    <th>{{trans('student::local.acceptance')}}</th>                              
                                    <th>{{trans('student::local.show_tests')}}</th>                              
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
                    "text": "{{trans('student::local.new_assessment')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('assessment-result.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'assessment-result.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('assessment-result.index') }}",
          columns: [
            {data: 'check',                 name: 'check', orderable: false, searchable: false},
            {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'application_date',      name: 'application_date'}, 
            {data: 'student_number',        name: 'student_number'}, 
            {data: 'studentName',           name: 'studentName'},
            {data: 'student_type',          name: 'student_type'},                                       
            {data: 'grade',                 name: 'grade'},                     
            {data: 'division',              name: 'division'},                     
            {data: 'assessment_type',       name: 'assessment_type'},                     
            {data: 'acceptance',            name: 'acceptance'},                     
            {data: 'show_tests',            name: 'show_tests'},                     
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
</script>
  @include('layouts.backEnd.includes.datatables._datatable')
@endsection

 