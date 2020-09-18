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
        <div class="card-header">
            <h4 class="card-title">{{$title}}</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            @include('student::students-affairs.students-statements._filter')
        </div>
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
                            <th>{{ trans('student::local.student_name') }}</th>          
                            <th>{{ trans('student::local.student_id_number') }}</th>
                            <th>{{ trans('student::local.register_status_id') }}</th>
                            <th>{{ trans('student::local.dob') }}</th>
                            <th>{{ trans('student::local.dd') }}</th>                      
                            <th>{{ trans('student::local.mm') }}</th>                      
                            <th>{{ trans('student::local.yy') }}</th>                                                                                  
                            <th>{{ trans('student::local.grade') }}</th>                                                                                  
                            <th>{{ trans('student::local.year') }}</th>                                                                                  
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
@include('student::students-affairs.students-statements._restore_migration')
@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                // new btn
                {
                    "text": "{{trans('student::local.data_migration')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('statements.create')}}";
                        }
                },
                // new btn
                {
                    "text": "{{trans('student::local.restore_migration')}}",
                    "className": "btn btn-dark mr-1",
                    action : function ( e, dt, node, config ) {
                      $('#restoreMigration').modal({backdrop: 'static', keyboard: false})
				              $('#restoreMigration').modal('show');
                        }
                },                
                
                // print 
                {
                    "text": "{{trans('student::local.print_statement')}}",
                    "className": "btn btn-primary buttons-print btn-primary mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('statements.create')}}";
                        }
                },  
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'statements.destroy'])                 
                // new btn
                {
                    "text": "{{trans('student::local.set_migration')}}",
                    "className": "btn btn-light mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('setMigration.index')}}";
                        }
                },                
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('statements.index') }}",
          columns: [
              {data: 'check',                       name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',                 name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'student_name',                name: 'student_name'},                       
              {data: 'student_id_number',           name: 'student_id_number'},              
              {data: 'regStatus',                   name: 'regStatus'},
              {data: 'dob',                         name: 'dob'},              
              {data: 'dd',                          name: 'dd'},              
              {data: 'mm',                          name: 'mm'},              
              {data: 'yy',                          name: 'yy'},   
              {data: 'grade',                       name: 'grade'},                                      
              {data: 'year',                        name: 'year'},   
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
    $('#btnRestore').on('click',function(){
      event.preventDefault();
        var form_data = $('#formRestore').serialize();
        $.ajax({
            url:"{{route('statements.restore')}}",
            method:"POST",
            data:form_data,
            dataType:"json",
            // display succees message
            success:function(data)
            {
                $('#dynamic-table').DataTable().ajax.reload();
                $('#restoreMigration').modal('hide');
                if(data.status == true)
                {
                  swal("{{trans('msg.success')}}", "", "success");
                }else{
                  swal("{{trans('msg.error')}}", data.msg, "error");
                }
                
            }
          })
    })
</script>
<script>
function filter()
{
  $('#dynamic-table').DataTable().destroy();
  var grade_id 		  = $('#filter_grade_id').val();
  var division_id   = $('#filter_division_id').val();
  var year_id 		  = $('#filter_year_id').val();
  var status_id 		= $('#filter_status_id').val();
  var myTable = $('#dynamic-table').DataTable({
    @include('layouts.backEnd.includes.datatables._datatableConfig')            
        buttons: [
            // new btn
            {
                "text": "{{trans('student::local.data_migration')}}",
                "className": "btn btn-success buttons-print btn-success mr-1",
                action : function ( e, dt, node, config ) {
                    window.location.href = "{{route('statements.create')}}";
                    }
            },              
            // new btn
            {
                "text": "{{trans('student::local.restore_migration')}}",
                "className": "btn btn-dark buttons-print btn-dark mr-1",
                action : function ( e, dt, node, config ) {
                      $('#restoreMigration').modal({backdrop: 'static', keyboard: false})
                      $('#restoreMigration').modal('show');
                    }
            },                
            
            // print 
            {
                "text": "{{trans('student::local.print_statement')}}",
                "className": "btn btn-primary buttons-print btn-primary mr-1",
                action : function ( e, dt, node, config ) {
                    window.location.href = "{{route('statements.create')}}";
                    }
            },     
                  
            // delete btn
            @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'statements.destroy'])    
            // new btn
            {
                "text": "{{trans('student::local.set_migration')}}",
                "className": "btn btn-light mr-1",
                action : function ( e, dt, node, config ) {
                    window.location.href = "{{route('setMigration.index')}}";
                    }
            },                  
            // default btns
            @include('layouts.backEnd.includes.datatables._datatableBtn')              
        ],
        ajax:{
            type:'POST',
            url:'{{route("statements.filter")}}',
            data: {
                _method     : 'PUT',
                grade_id    : grade_id,
                division_id : division_id,
                year_id     : year_id,
                status_id   : status_id,
                _token      : '{{ csrf_token() }}'
            }
          },
        columns: [
          {data: 'check',                       name: 'check', orderable: false, searchable: false},
          {data: 'DT_RowIndex',                 name: 'DT_RowIndex', orderable: false, searchable: false},
          {data: 'student_name',                name: 'student_name'},                       
          {data: 'student_id_number',           name: 'student_id_number'},              
          {data: 'regStatus',                   name: 'regStatus'},
          {data: 'dob',                         name: 'dob'},              
          {data: 'dd',                          name: 'dd'},              
          {data: 'mm',                          name: 'mm'},              
          {data: 'yy',                          name: 'yy'},                                      
          {data: 'grade',                       name: 'grade'},                                      
          {data: 'year',                        name: 'year'},                                      
      ],
      @include('layouts.backEnd.includes.datatables._datatableLang')
  });
  @include('layouts.backEnd.includes.datatables._multiSelect')
}    
</script>    
@include('layouts.backEnd.includes.datatables._datatable')
@endsection

 