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
    <div class="col-6">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1 red">{{ trans('student::local.statistics_grade') }} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            @include('student::students-affairs.distributions-students.includes._filter')
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive mt-1">
                  
                  <table class="table">
                      <thead>
                          <tr>
                              <th>{{ trans('student::local.boy') }}</th>
                              <th>{{ trans('student::local.girl') }}</th>
                              <th>{{ trans('student::local.muslim') }}</th>
                              <th>{{ trans('student::local.non_muslim') }}</th>
                              <th>{{ trans('student::local.total_statge') }}</th>
                          </tr>
                      </thead>
                      <tbody id="all">
                          
                      </tbody>
                  </table> 
                  
                  <table class="table">
                    <thead>
                      <tr>
                          <th>{{ trans('student::local.languages') }}</th>
                          <th>{{ trans('student::local.students_count') }}</th>
                      </tr>  
                    </thead>
                    <tbody id="langGrade">
                        
                    </tbody>
                </table>                   
                </div>  
              </div>          
            </div>                           
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title purple  mb-1">{{ trans('student::local.statistics_class') }}</h4>          
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>          
          <div class="row">
            <div class="col-md-12">
              <form action="{{route('distribution.nameList')}}" method="get">
                  <div class="row">
                      <div class="col-md-4">
                        <select name="room_id" class="form-control" id="filter_room_id" disabled>
                          <option value="">{{ trans('student::local.classrooms') }}</option>                    
                        </select>
                      </div>   
                      <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-min-width ml-1">{{ trans('admin.print') }}</button>
                      </div>                                   
                  </div> 
              </form>                                
              <div class="table-responsive mt-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('student::local.boy') }}</th>
                            <th>{{ trans('student::local.girl') }}</th>
                            <th>{{ trans('student::local.muslim') }}</th>
                            <th>{{ trans('student::local.non_muslim') }}</th>
                            <th>{{ trans('student::local.total_class') }}</th>
                        </tr>
                    </thead>
                    <tbody id="room">
                        
                    </tbody>
                </table>
            
                <table class="table">
                    <thead>
                      <tr>
                          <th>{{ trans('student::local.languages') }}</th>
                          <th>{{ trans('student::local.students_count') }}</th>
                      </tr>  
                    </thead>
                    <tbody id="langClass">
                        
                    </tbody>
                </table>                  
              </div>  
            </div>             
          </div>
           
          <a href="#" onclick="joinToClass()" class="btn btn-success mb-1">
            {{ trans('student::local.join_students_class') }}
          </a>              
          <a href="#" onclick="removeFromClass()" class="btn btn-danger mb-1">
            {{ trans('student::local.remove_from_class') }}
          </a>  
          <a href="#" onclick="moveToClass()" class="btn btn-light mb-1">
            {{ trans('student::local.move_to_class') }}
          </a>                         
        </div>
      </div>
    </div>    
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ trans('student::local.statistics_grade') }}</h4>
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
                                <th>{{trans('student::local.student_number')}}</th>
                                <th>{{trans('student::local.student_name')}}</th>
                                <th>{{trans('student::local.gender')}}</th>
                                <th>{{trans('student::local.religion')}}</th>
                                <th>{{trans('student::local.second_lang_id')}}</th>
                                <th>{{trans('student::local.student_age')}}</th>
                                <th>{{trans('student::local.classroom')}}</th>                                
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

@include('student::students-affairs.distributions-students.includes._move-to-class')
@endsection
@section('script')
<script>

    $('#filter_division_id').on('change', function(){
      getRooms();
    });  
    $('#filter_grade_id').on('change', function(){
      getRooms();
      filter();
    });      
    function getRooms()
    {
          var filter_division_id = $('#filter_division_id').val();  
          var filter_grade_id = $('#filter_grade_id').val();  

          if (filter_grade_id == '' || filter_division_id == '') // is empty
          {
            $('#filter_room_id').prop('disabled', true); // set disable
            $('#to_room_id').prop('disabled', true); // set disable
          }
          else // is not empty
          {
            $('#filter_room_id').prop('disabled', false);	// set enable
            $('#to_room_id').prop('disabled', false);	// set enable
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
                $('#filter_room_id').html(data);
                $('#to_room_id').html(data);
              }
            });
          }
    }  
    function filter()
    {
        getRooms()
        var filter_division_id  = $('#filter_division_id').val();  
        var filter_grade_id     = $('#filter_grade_id').val();  
        var filter_room_id      = $('#filter_room_id').val(); 

        if (filter_grade_id == '' || filter_division_id == '') // is empty
        {
          $('#filter_room_id').prop('disabled', true); // set disable
        }
        else // is not empty
        {
          $('#filter_room_id').prop('disabled', false);	// set enable
          //using
          $.ajax({
            url:'{{route("distribution.getGradeStatistics")}}',
            type:"post",
            data: {
              _method		    : 'PUT',
              division_id 	: filter_division_id,
              grade_id 	    : filter_grade_id,
              room_id 	    : filter_room_id,
              _token		    : '{{ csrf_token() }}'
              },
            dataType: 'json',
            success: function(data){
              var tbody = `<tr>
                  <td class="blue">`+(data.male)+`</td><td class="blue">`+(data.female)+`</td>
                  <td class="purple">`+(data.muslim)+`</td><td class="purple">`+(data.non_muslim)+`</td>
                  <td class="red">`+(data.male + data.female)+`</td>
                </tr>`
              $('#all').html(tbody);

              getClassStatistics();
              langGrade();
            }
          });
        }

        getStudentsGrade();
    } 
    function getStudentsGrade()
    {
      event.preventDefault();
      if ($('#filter_division_id').val() == '') {
        swal("{{trans('student::local.no_division_selected')}}", "", "error");
        return;
      }
      if ($('#filter_grade_id').val() == '') {
        swal("{{trans('student::local.no_grade_selected')}}", "", "error");
        return;
      }  
      if ($('#filter_room_id').text() == '') {
        swal("{{trans('student::local.no_rooms_selected')}}", "", "error");
        return;
      }  
      $('#dynamic-table').DataTable().destroy();
      var grade_id 		  = $('#filter_grade_id').val();
      var division_id   = $('#filter_division_id').val();      
      
      var myTable = $('#dynamic-table').DataTable({
        "info":     true,
        "pageLength": 15, // set page records
        "lengthMenu": [10,20, 50,100,200,500],
        "bLengthChange" : true,
        dom: 'lfrtip', 
        ajax:{
            type:'POST',
            url:'{{route("distribution.allStudentsGrade")}}',
            data: {
                _method     : 'PUT',
                grade_id    : grade_id,
                division_id : division_id,              
                _token      : '{{ csrf_token() }}'
            }
          },
          // columns
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', searchable: false},
              {data: 'student_number',      name: 'student_number'},                
              {data: 'student_name',        name: 'student_name'},              
              {data: 'gender',              name: 'gender'},              
              {data: 'religion',            name: 'religion'}, 
              {data: 'second_lang_id',      name: 'second_lang_id'}, 
              {data: 'yy',                  name: 'yy'}, 
              {data: 'classroom_id',        name: 'classroom_id'}, 
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')      
    }
    function joinToClass()
    {
        event.preventDefault();
        var classroom = $('#filter_room_id').find(":selected").text(); 
        var roomId = $('#filter_room_id').val();  
        var form_data = $('#formData').serializeArray();
        form_data.push({name: "roomId", value: roomId});
        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
        if (itemChecked > 0) {
            swal({
                title: "{{trans('student::local.join_students_class')}}",
                text: "{{trans('student::local.cofirm_join_student')}}" + classroom,
                showCancelButton: true,
                confirmButtonColor: "#87B87F",
                confirmButtonText: "{{trans('msg.yes')}}",
                cancelButtonText: "{{trans('msg.no')}}",
                closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('distribution.joinToClassroom')}}",
                        method:"POST",
                        data:form_data,
                        dataType:"json",
                        // display succees message
                        success:function(data)
                        {
                            $('#dynamic-table').DataTable().ajax.reload();
                            getClassStatistics()
                        }
                    })
                    // display success confirm message
                    .done(function(data) {                                    
                        if(data.status == true)
                        {
                          swal("{{trans('msg.success')}}", "", "success");
                        }else{
                          swal("{{trans('msg.error')}}", data.msg, "error");
                        }
                    })
                }
            );
          // end swal                        
        } else{
          swal("{{trans('student::local.join_students_class')}}", "{{trans('msg.no_records_selected')}}", "info");
        }      
    }
    function removeFromClass()
    {
      event.preventDefault();        
        var roomId = $('#filter_room_id').val();  
        var form_data = $('#formData').serialize();
        
        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
        if (itemChecked > 0) {
            swal({
                title: "{{trans('student::local.remove_from_class')}}",
                text: "{{trans('student::local.cofirm_remove_student')}}",
                showCancelButton: true,
                confirmButtonColor: "#87B87F",
                confirmButtonText: "{{trans('msg.yes')}}",
                cancelButtonText: "{{trans('msg.no')}}",
                closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('distribution.removeFromClassroom')}}",
                        method:"POST",
                        data:form_data,
                        dataType:"json",
                        // display succees message
                        success:function(data)
                        {
                            $('#dynamic-table').DataTable().ajax.reload();
                            getClassStatistics()
                        }
                    })
                    // display success confirm message
                    .done(function(data) {                                    
                        if(data.status == true)
                        {
                          swal("{{trans('msg.success')}}", "", "success");
                        }else{
                          swal("{{trans('msg.error')}}", data.msg, "error");
                        }
                    })
                }
            );
          // end swal                        
        } else{
          swal("{{trans('student::local.remove_from_class')}}", "{{trans('msg.no_records_selected')}}", "info");
        }          
    }
    $('#filter_room_id').on('change',function(){        
      getClassStatistics();
    })
    function getClassStatistics()
    {
      var filter_room_id      = $('#filter_room_id').val(); 
        $.ajax({
              url:'{{route("distribution.getClassStatistics")}}',
              type:"post",
              data: {
                _method		    : 'PUT',                
                room_id 	    : filter_room_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){
                var tbody = `<tr>
                    <td class="blue">`+(data.male_room)+`</td><td class="blue">`+(data.female_room)+`</td>
                    <td class="purple">`+(data.muslim_room)+`</td><td class="purple">`+(data.non_muslim_room)+`</td>
                    <td class="red">`+(data.male_room + data.female_room)+`</td>
                  </tr>`
                $('#room').html(tbody);
              }
          });
      lang();
    }
    function langGrade()
    {
      var filter_division_id   = $('#filter_division_id').val(); 
      var filter_grade_id      = $('#filter_grade_id').val(); 
        $.ajax({
              url:'{{route("distribution.getLanguagesGrade")}}',
              type:"post",
              data: {
                _method		    : 'PUT',                
                division_id 	: filter_division_id,
                grade_id 	    : filter_grade_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){               
                $('#langGrade').html(data);
              }
          });
    }  
    function lang()
    {
      var filter_room_id      = $('#filter_room_id').val(); 
        $.ajax({
              url:'{{route("distribution.getLanguagesClass")}}',
              type:"post",
              data: {
                _method		    : 'PUT',                
                room_id 	    : filter_room_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){               
                $('#langClass').html(data);
              }
          });
    }    
    function moveToClass()
    {
      // validations
      if ($('#filter_division_id').val() == '') {
        swal("{{trans('student::local.no_division_selected')}}", "", "error");
        return;
      }
      if ($('#filter_grade_id').val() == '') {
        swal("{{trans('student::local.no_grade_selected')}}", "", "error");
        return;
      }  
      if ($('#filter_room_id').text() == '') {
        swal("{{trans('student::local.no_rooms_selected')}}", "", "error");
        return;
      }  

      $('#divId').html($('#filter_division_id').find(":selected").text());   
      $('#graId').html($('#filter_grade_id').find(":selected").text());   
      
      $('#moveToClass').modal({backdrop: 'static', keyboard: false})
      $('#moveToClass').modal('show');      
    }  
    // inserting 
    $('#btnMoveToClass').on('click',function(){
      event.preventDefault();
        var form_data = $('#formMove').serialize();
        $.ajax({
            url:"{{route('distribution.moveToClass')}}",
            method:"POST",
            data:form_data,
            dataType:"json",
            // display succees message
            success:function(data)
            {
              if (data.status == true) {
                getClassStatistics();
                $('#dynamic-table').DataTable().ajax.reload();   
                swal("{{trans('msg.success')}}", "", "success");                                             
              }else{
                swal("{{trans('msg.error')}}", data.msg, "error");                                             
              }
            }
          })
    })   
    
    $('#from_year_id').on('change', function(){
          var filter_division_id = $('#filter_division_id').val();  
          var filter_grade_id = $('#filter_grade_id').val();  
          var from_year_id = $('#from_year_id').val();  

          if (filter_grade_id == '' || filter_division_id == '') // is empty
          {
            $('#from_room_id').prop('disabled', true); // set disable            
          }
          else // is not empty
          {
            $('#from_room_id').prop('disabled', false);	// set enable            
            //using
            $.ajax({
              url:'{{route("getOldClassrooms")}}',
              type:"post",
              data: {
                _method		    : 'PUT',
                division_id 	: filter_division_id,
                grade_id 	    : filter_grade_id,
                year_id 	    : from_year_id,
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){
                $('#from_room_id').html(data);                
              }
            });
          }      
    });      
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection