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
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
        <h4 class="card-title">{{ trans('student::local.today_absence') }} {{  date_format(Carbon\Carbon::today(),"Y/m/d")}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            @include('student::students-affairs.absence.includes._filter')            
              <div class="table-responsive">
                  <form action="" id='formData' method="post">
                    @csrf
                    <table id="dynamic-table" class="table data-table" >
                        <thead class="bg-info white">
                            <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('student::local.student_image')}}</th>
                                <th>{{trans('student::local.student_number')}}</th>
                                <th>{{trans('student::local.student_name')}}</th>                                
                                <th>{{trans('student::local.grade')}}</th>
                                <th>{{trans('student::local.notes')}}</th>
                                <th>{{trans('student::local.status')}}</th>
                                <th>{{trans('student::local.created_by')}}</th>
                                <th>{{trans('student::local.created_at')}}</th>
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
@include('student::students-affairs.absence.includes._monthly-statement')
@endsection
@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'absences.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('absences.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'student_image',       name: 'student_image'},
              {data: 'student_number',      name: 'student_number'},
              {data: 'student_name',        name: 'student_name'},               
              {data: 'grade',               name: 'grade'},               
              {data: 'notes',               name: 'notes'},               
              {data: 'status',              name: 'status'},               
              {data: 'created_by',          name: 'created_by'},               
              {data: 'created_at',          name: 'created_at'},               
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });

    function filter()
    {
      event.preventDefault();
      $('#dynamic-table').DataTable().destroy();
      var classroom_id 	= $('#filter_classroom_id').val();
      
      var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
        buttons: [
            // delete btn
            @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'absences.destroy'])

            // default btns
            @include('layouts.backEnd.includes.datatables._datatableBtn')
        ],
        ajax:{
            type:'POST',
            url:'{{route("absences.filter")}}',
            data: {
                _method       : 'PUT',
                classroom_id  : classroom_id,                
                _token        : '{{ csrf_token() }}'
            }
          },
          // columns
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'student_image',       name: 'student_image'},
              {data: 'student_number',      name: 'student_number'},
              {data: 'student_name',        name: 'student_name'},               
              {data: 'grade',               name: 'grade'},               
              {data: 'notes',               name: 'notes'},               
              {data: 'status',              name: 'status'},               
              {data: 'created_by',          name: 'created_by'},               
              {data: 'created_at',          name: 'created_at'},               
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    }  

    $('#filter_division_id').on('change', function(){
      getRooms();
    });  
    $('#filter_grade_id').on('change', function(){
      getRooms();
    }); 
    $('#monthly_division_id').on('change', function(){
      getRoomsMonthly();
    });  
    $('#monthly_grade_id').on('change', function(){
      getRoomsMonthly();
    });            
    function getRooms()
    {
          var filter_division_id = $('#filter_division_id').val();            
          var filter_grade_id = $('#filter_grade_id').val();            

          if (filter_division_id == '' || filter_grade_id == '') // is empty
          {
            $('#filter_classroom_id').prop('disabled', true); // set disable                        
          }
          else // is not empty
          {
            $('#filter_classroom_id').prop('disabled', false);	// set enable                        
            //using
            $.ajax({
              url:'{{route("getClassrooms")}}',
              type:"post",
              data: {
                _method		    : 'PUT',
                division_id 	: filter_division_id,
                grade_id 	    : filter_grade_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){
                $('#filter_classroom_id').html(data);                                
              }
            });
          }
    }  
    function getRoomsMonthly()
    {          
          var monthly_division_id = $('#monthly_division_id').val();            
          var monthly_grade_id = $('#monthly_grade_id').val();  

          if (monthly_division_id == '' || monthly_grade_id == '') // is empty
          {            
            $('#monthly_classroom_id').prop('disabled', true); // set disable            
          }
          else // is not empty
          {            
            $('#monthly_classroom_id').prop('disabled', false);	// set enable            
            //using
            $.ajax({
              url:'{{route("getClassrooms")}}',
              type:"post",
              data: {
                _method		    : 'PUT',
                division_id 	: monthly_division_id,
                grade_id 	    : monthly_grade_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){                
                $('#monthly_classroom_id').html(data);                
              }
            });
          }
    }      
    function monthlyStatement()
    {
      $('#monthly_statement').modal({backdrop: 'static', keyboard: false})
      $('#monthly_statement').modal('show');
    } 
    function getMonthStatement()
    {
      $('#formMonthStatement').attr('action',"{{route('absences.print-month-statement')}}");
      $('#formMonthStatement').submit();
    }          
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection