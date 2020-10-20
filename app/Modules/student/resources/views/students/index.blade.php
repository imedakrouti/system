@extends('layouts.backEnd.cpanel')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
@include('student::students.includes._filter')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$title}} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>          
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
                                <th>{{trans('student::local.student_number')}}</th>
                                <th>{{trans('student::local.student_type')}}</th>
                                <th>{{trans('student::local.registration_status')}}</th>                                
                                <th>{{trans('student::local.grade')}}</th>                                
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
            buttons: [
                // new
                @include('student::students-affairs.students-statements.includes._storeToStatement')
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'students.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('students.index') }}",
          @include('student::students.includes._dataTable-columns'),
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    function filter()
    {
      event.preventDefault();
      $('#dynamic-table').DataTable().destroy();
      var grade_id 		  = $('#filter_grade_id').val();
      var division_id   = $('#filter_division_id').val();
      var status_id 		= $('#filter_status_id').val();
      var student_type 	= $('#filter_student_type').val();
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        buttons: [
                    // new
                    @include('student::students-affairs.students-statements.includes._storeToStatement')
                    // delete btn
                    @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'students.destroy'])

                    // default btns
                    @include('layouts.backEnd.includes.datatables._datatableBtn')
                ],
        ajax:{
            type:'POST',
            url:'{{route("students.filter")}}',
            data: {
                _method       : 'PUT',
                grade_id      : grade_id,
                division_id   : division_id,            
                status_id     : status_id,
                student_type  : student_type,
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          @include('student::students.includes._dataTable-columns'),
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    }      
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
