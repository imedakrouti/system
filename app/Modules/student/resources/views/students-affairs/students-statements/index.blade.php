@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
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
            <h4 class="card-title">{{$title}} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            @include('student::students-affairs.students-statements.includes._filter')

            @include('layouts.backEnd.includes._error-msg')
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
                            <th>{{ trans('student::local.student_image') }}</th>          
                            <th>{{ trans('student::local.student_number') }}</th>          
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
@include('student::students-affairs.students-statements.includes._restore_migration')
@include('student::students-affairs.students-statements.includes._instructions')
@endsection
@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        // buttons
        @include('student::students-affairs.students-statements.includes._dataTable-buttons'),
        ajax: "{{ route('statements.index') }}",
        // columns
        @include('student::students-affairs.students-statements.includes._dataTable-columns'),
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
  event.preventDefault();
  $('#dynamic-table').DataTable().destroy();
  var grade_id 		  = $('#filter_grade_id').val();
  var division_id   = $('#filter_division_id').val();
  var year_id 		  = $('#filter_year_id').val();
  var status_id 		= $('#filter_status_id').val();
  var myTable = $('#dynamic-table').DataTable({
    @include('layouts.backEnd.includes.datatables._datatableConfig')            
    @include('student::students-affairs.students-statements.includes._dataTable-buttons'),
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
      // columns
      @include('student::students-affairs.students-statements.includes._dataTable-columns'),
      @include('layouts.backEnd.includes.datatables._datatableLang')
  });
  @include('layouts.backEnd.includes.datatables._multiSelect')
}   
function printStatement()
{
  $('#filterForm').attr('action',"{{route('statements.printStatement')}}");
  $('#filterForm').submit();
} 
function statistics()
{
  $('#filterForm').attr('action',"{{route('statistics.report')}}");
  $('#filterForm').submit();
} 
</script>    
@include('layouts.backEnd.includes.datatables._datatable')
@endsection

 