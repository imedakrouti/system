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
            <h4 class="card-title mb-1 red"> <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            @include('student::students-affairs.cards.includes._filter')
                               
        </div>
      </div>
    </div>
   
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">          
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
                                  <th>{{trans('student::local.student_number')}}</th>
                                  <th>{{trans('student::local.student_name')}}</th>
                                  <th>{{trans('student::local.gender')}}</th>
                                  <th>{{trans('student::local.religion')}}</th>                                                                    
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

    $('#filter_division_id').on('change', function(){
      getRooms();
    });  
    $('#filter_grade_id').on('change', function(){
      getRooms();
    });      
    function getRooms()
    {
          var filter_division_id = $('#filter_division_id').val();  
          var filter_grade_id = $('#filter_grade_id').val();  

          if (filter_grade_id == '' || filter_division_id == '') // is empty
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

    function filter()
    {
      event.preventDefault();

      $('#dynamic-table').DataTable().destroy();
      var grade_id 		 = $('#filter_grade_id').val();
      var division_id    = $('#filter_division_id').val();      
      var classroom_id   = $('#filter_classroom_id').val();      
      
      var myTable = $('#dynamic-table').DataTable({
        "info":     true,
        "pageLength": 20, // set page records
        "lengthMenu": [10,20, 50,100,200,500],
        "bLengthChange" : true,
        dom: 'Blfrtip',
        buttons: [
                // new btn
                {
                    "text": "{{trans('student::local.selected_studentes')}}",
                    "className": "btn btn-primary buttons-print btn-primary mr-1",
                    action : function ( e, dt, node, config ) {                        
                        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
                        if (itemChecked > 0) {
                            $.each($('#formData').serializeArray(), function() {
                                if (this.name == 'id[]') {
                                    $("<input />").attr("type", "hidden")
                                    .attr("name", "id[]")
                                    .attr("value",this.value)
                                    .appendTo("#filterForm");                                    
                                }                     
                        });
                            $('#filterForm').submit();                            
                        }else{
                            swal("{{trans('student::local.students_id_card')}}", "{{trans('msg.no_records_selected')}}", "info");
                        }
                    }
                },                

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
        ajax:{
            type:'POST',
            url:'{{route("get-student-cards")}}',
            data: {
                _method     : 'PUT',
                grade_id    : grade_id,
                division_id : division_id,              
                classroom_id : classroom_id,              
                _token      : '{{ csrf_token() }}'
            }
          },
          // columns
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', searchable: false},
              {data: 'studentImage',        name: 'studentImage'},                
              {data: 'student_number',      name: 'student_number'},                
              {data: 'student_name',        name: 'student_name'},              
              {data: 'gender',              name: 'gender'},              
              {data: 'religion',            name: 'religion'},                                           
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')      
    }

      
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection