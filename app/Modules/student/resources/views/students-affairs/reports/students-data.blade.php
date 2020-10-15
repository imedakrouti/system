@extends('layouts.backEnd.cpanel')
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
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    <h4>{{ trans('student::local.statistics_note') }} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
                    <form action="#" method="get" id="filterForm" target="_blank">
                          <div class="row mt-1" >
                              <div class="col-lg-3 mr-1 mb-md-1  col-md-5">
                                <div class="row">
                                  <select name="year_id" class="form-control select2" id="filter_year_id">                                      
                                      @foreach ($years as $year)
                                          <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                    
                                      @endforeach
                                  </select>  
                                </div>  
                              </div>        
                              <div class="col-lg-3 mr-1 mb-md-1  col-md-5">
                                <div class="row">
                                  <select name="division_id[]" class="form-control select2" multiple id="filter_division_id">                                      
                                      @foreach ($divisions as $division)
                                          <option {{session('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                                              {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                                      @endforeach
                                  </select>
                                </div>
                              </div> 
                              <div class="col-lg-3 mr-1 mb-md-1  col-md-5">
                                <div class="row">
                                  <select name="grade_id" class="form-control select2" id="filter_grade_id">                
                                    @foreach ($grades as $grade)
                                        <option value="{{$grade->id}}">
                                            {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                                    @endforeach
                                </select>
                                </div>
                              </div>                                
                              <div class="col-lg-3 mr-1 mb-md-1  col-md-5">
                                <div class="row">
                                  <select name="room_id" class="form-control select2" id="filter_room_id" disabled>
                                  <option value="">{{ trans('student::local.classrooms') }}</option>                    
                                </select>
                                </div>
                              </div> 
                              <div class="col-lg-3 mr-1 mb-md-1  col-md-5">
                                <div class="row">
                                  <select name="lang_id" class="form-control select2" id="filter_lang_id">                
                                    @foreach ($languages as $language)
                                        <option value="{{$language->id}}">
                                            {{session('lang') =='ar' ?$language->ar_name_lang:$language->en_name_lang}}</option>                                    
                                    @endforeach
                                </select>
                                </div>
                              </div>
                              <div class="col-lg-3 mr-1 mb-md-1  col-md-5">
                                <div class="row">
                                  <select name="religion_id" class="form-control select2" id="filter_religion_id">
                                  <option value="muslim">{{ trans('student::local.muslim') }}</option>                    
                                  <option value="non_muslim">{{ trans('student::local.non_muslim') }}</option>                    
                                </select>
                                </div>
                              </div>                                                                                        
                          </div>
                    </form>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">  
              <h4 class="purple ml-2">{{ trans('student::local.reports') }}</h4>
                    <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="list-group col-md-6">
                            <button type="button" onclick="printStatement()" class="list-group-item list-group-item-action">{{trans('student::local.students_statements') }}</button>
                            <button type="button" onclick="studentsContactsData()" class="list-group-item list-group-item-action">{{trans('student::local.student_contacts_data') }}</button>
                            <button type="button" onclick="nameList()" class="list-group-item list-group-item-action">{{trans('student::local.name_list') }}</button> 
                            <button type="button" onclick="SecondlangData()" class="list-group-item list-group-item-action">{{trans('student::local.name_list_second_lang') }}</button>
                            <button type="button" onclick="religionData()" class="list-group-item list-group-item-action">{{trans('student::local.name_list_religion') }}</button>
                            {{-- <button type="button" class="list-group-item list-group-item-action">{{trans('student::local.students_usernames') }}</button>         --}}       
                          </div>
                        </div>
                    </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        function printStatement()
        {
            $('#filterForm').attr('action',"{{route('statements.printStatement')}}");
            $('#filterForm').submit();
        } 

        function studentsContactsData()
        {
            $('#filterForm').attr('action',"{{route('students-contact-data')}}");
            $('#filterForm').submit();
        } 

        function nameList()
        {
            $('#filterForm').attr('action',"{{route('distribution.nameList')}}");
            $('#filterForm').submit();
        }

        function SecondlangData()
        {
            $('#filterForm').attr('action',"{{route('students-second-lang')}}");
            $('#filterForm').submit();
        } 

        function religionData()
        {
            $('#filterForm').attr('action',"{{route('students-religion')}}");
            $('#filterForm').submit();
        }   

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
            $('#filter_room_id').prop('disabled', true); // set disable            
          }
          else // is not empty
          {
            $('#filter_room_id').prop('disabled', false);	// set enable            
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
              }
            });
          }
    }                               
    </script>
@endsection
