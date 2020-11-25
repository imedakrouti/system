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

        <div class="btn-group mr-1 mb-1 float-right">
            <button type="button" class="btn btn-success btn-min-width dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.add_homework') }}</button>
            <div class="dropdown-menu">
            <a class="dropdown-item" onclick="assignment()" href="#"><i class="la la-sticky-note"></i>{{ trans('learning::local.assignment') }}</a>
            <a class="dropdown-item" onclick="question()" href="#"><i class="la la-question"></i>{{ trans('learning::local.add_questions') }}</a>                  
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
                      <thead class="bg-info white">
                          <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('learning::local.title')}}</th>                                
                                <th>{{trans('learning::local.subject')}}</th>                                                                                               
                                <th>{{trans('learning::local.total_mark')}}</th>                                                                                               
                                <th>{{trans('learning::local.due_date')}}</th>                                                                
                                <th>{{trans('learning::local.show_homework')}}</th>                                                                                                                               
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

@include('learning::teacher.posts.includes._homework-assignment')                                    
@include('learning::teacher.posts.includes._homework-question')                                    
@endsection

@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'homeworks.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('teacher.homeworks') }}",
          columns: [
                {data: 'check',         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title',         name: 'title'},
                {data: 'subject',       name: 'subject'},
                {data: 'total_mark',    name: 'total_mark'},                                          
                {data: 'due_date',      name: 'due_date'},                
                {data: 'show_homework', name: 'show_homework'},                                                          
                {data: 'action', 	      name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

    function assignment()
        {            
            $('#assignment').modal({backdrop: 'static', keyboard: false})
            $('#assignment').modal('show');
        }
        function question()
        {            
            $('#question').modal({backdrop: 'static', keyboard: false})
            $('#question').modal('show');
        }
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
