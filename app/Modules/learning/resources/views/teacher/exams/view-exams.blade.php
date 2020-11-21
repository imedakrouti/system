@extends('layouts.backEnd.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      
    </div>  
    <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <a href="{{route('teacher.new-exam')}}"  class="btn btn-success box-shadow round">{{ trans('learning::local.new_exam') }}</a>
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
                      <thead class="bg-info white">
                          <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('learning::local.exam_name')}}</th>                                
                                <th>{{trans('learning::local.start_exam')}}</th>                                
                                <th>{{trans('learning::local.end_exam')}}</th>                                                                                               
                                <th>{{trans('learning::local.exam_duration')}}</th>                                                                                               
                                <th>{{trans('learning::local.total_mark')}}</th>                                                                                               
                                <th>{{trans('learning::local.show_questions')}}</th>                                                                                               
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
            buttons: [
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'exams.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('teacher.view-exams') }}",
          columns: [
                {data: 'check',         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'exam_name',     name: 'exam_name'},
                {data: 'start',         name: 'start'},
                {data: 'end',           name: 'end'},
                {data: 'duration',      name: 'duration'},
                {data: 'total_mark',    name: 'total_mark'},                                          
                {data: 'show_questions',name: 'show_questions'},                                          
                {data: 'action', 	      name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
