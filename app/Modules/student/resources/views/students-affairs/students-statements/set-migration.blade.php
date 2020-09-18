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
            <li class="breadcrumb-item"><a href="{{route('statements.index')}}">{{ trans('student::local.students_statements') }}</a></li>            
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
@include('student::students-affairs.students-statements._set')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="" id='formData' method="post">
                      @csrf
                      <table id="dynamic-table" class="table data-table" >
                          <thead class="bg-info white">
                              <tr>
                                  <th><input type="checkbox" class="ace" /></th>
                                  <th>#</th>
                                  <th>{{trans('student::local.fromGrade')}}</th>
                                  <th>{{trans('student::local.toGrade')}}</th>                                  
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
                    "text": "{{trans('student::local.set_grades')}}",
                    "className": "btn btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                          $('#setModal').modal({backdrop: 'static', keyboard: false})
                          $('#setModal').modal('show');
                        }
                },                     
                // delete btn,                
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'setMigration.destroy'])
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('setMigration.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'from_grade_id',       name: 'from_grade_id'},
              {data: 'to_grade_id',         name: 'to_grade_id'},
              
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    $('#btnSave').on('click',function(event){
        event.preventDefault();
        var form_data = $('#frm').serialize();
        $.ajax({
            url:"{{route('setMigration.store')}}",
            method:"POST",
            data:form_data,
            dataType:"json",
            // display succees message
            success:function(data)
            {
                $('#dynamic-table').DataTable().ajax.reload();
            }
            })
        // end swal
    })        
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection