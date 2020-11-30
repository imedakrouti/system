@extends('layouts.backEnd.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>  
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('teacher.view-exams')}}">{{ trans('learning::local.exams') }}</a>
            </li>           
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
        <div class="card-header">
            <h4 class="card-title mb-1"><strong>{{$exam->exam_name}}</strong></h4>
            <p>{{$exam->description}}</p>
          </div>
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
                                <th>{{trans('learning::local.student_name')}}</th>                                
                                <th>{{trans('student.exam_date')}}</th>                                
                                <th>{{trans('student.mark')}}</th>                                                                                                                               
                                <th>{{trans('student.evaluation')}}</th>                                                                                                                               
                                <th>{{trans('student.answers')}}</th>
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
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'exams.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('teacher.applicants',$exam_id) }}",
          columns: [
                {data: 'check',         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'student_image', name: 'student_image'},
                {data: 'student_name',  name: 'student_name'},
                {data: 'exam_date',     name: 'exam_date'},
                {data: 'mark',          name: 'mark'},                
                {data: 'evaluation',    name: 'evaluation'},                                          
                {data: 'answers',       name: 'answers'},                                          
                
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
