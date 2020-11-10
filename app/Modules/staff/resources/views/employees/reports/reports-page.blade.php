@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>            
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
                    <form action="#" method="get" id="filterForm" target="_blank">
                        <div class="row">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <select name="sector_id" class="form-control select2" id="filter_sector_id">
                                        <option value="">{{ trans('staff::local.sectors') }}</option>
                                        @foreach ($sectors as $sector)
                                            <option value="{{$sector->id}}">
                                                {{session('lang') =='ar' ?$sector->ar_sector:$sector->en_sector}}</option>                                    
                                        @endforeach
                                    </select>                                
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <select name="department_id" class="form-control select2" id="filter_department_id">
                                        <option value="">{{ trans('staff::local.departments') }}</option>                             
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <select name="section_id" class="form-control select2" id="filter_section_id">
                                        <option value="">{{ trans('staff::local.sections') }}</option>
                                        @foreach ($sections as $section)
                                            <option value="{{$section->id}}">
                                                {{session('lang') =='ar' ?$section->ar_section:$section->en_section}}</option>                                    
                                        @endforeach
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
              <h4 class="purple">{{ trans('staff::local.reports') }}</h4>           
              <div class="row">
                <div class="col-lg-4 col-md-12">                    
                    <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="list-group">
                            <button type="button" onclick="contacts()" class="list-group-item list-group-item-action"> 1- {{trans('staff::local.employees_contact') }}</button>
                            <button type="button" onclick="insurance()" class="list-group-item list-group-item-action">2- {{trans('staff::local.employees_insurance') }}</button>
                            <button type="button" onclick="tax()" class="list-group-item list-group-item-action">3- {{trans('staff::local.employees_tax') }}</button>        
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">                    
                    <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="list-group">
                            <button type="button" onclick="bus()" class="list-group-item list-group-item-action">4- {{trans('staff::local.employees_bus') }}</button>
                            <button type="button" onclick="salaries()" class="list-group-item list-group-item-action">5- {{trans('staff::local.employees_salaries') }}</button>
                            <button type="button" onclick="contract()" class="list-group-item list-group-item-action">6- {{trans('staff::local.employees_contract') }}</button>        
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">                    
                  <div class="card-content collapse show">
                      <div class="card-body">
                        <div class="list-group">
                          <button type="button" onclick="salarySuspended()" class="list-group-item list-group-item-action">7- {{trans('staff::local.employees_salary_suspended') }}</button>
                          <button type="button" onclick="timetable()" class="list-group-item list-group-item-action">8- {{trans('staff::local.employees_no_timetable') }}</button>
                          <button type="button" onclick="requiredDocument()" class="list-group-item list-group-item-action">9- {{trans('staff::local.employees_required_document') }}</button>                          
                        </div>
                      </div>
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
        function contacts()
        {
            $('#filterForm').attr('action',"{{route('employees.contacts')}}");
            $('#filterForm').submit();
        } 

        function insurance()
        {
            $('#filterForm').attr('action',"{{route('employees.insurance')}}");
            $('#filterForm').submit();
        } 

        function tax()
        {
            $('#filterForm').attr('action',"{{route('employees.tax')}}");
            $('#filterForm').submit();
        }

        function bus()
        {
            $('#filterForm').attr('action',"{{route('employees.bus')}}");
            $('#filterForm').submit();
        }

        function salaries()
        {
            $('#filterForm').attr('action',"{{route('employees.salaries')}}");
            $('#filterForm').submit();
        }

        function contract()
        {
            $('#filterForm').attr('action',"{{route('employees.contract')}}");
            $('#filterForm').submit();
        }

        function salarySuspended()
        {
            $('#filterForm').attr('action',"{{route('employees.salarySuspended')}}");
            $('#filterForm').submit();
        }
        function timetable()
        {
            $('#filterForm').attr('action',"{{route('employees.timetable')}}");
            $('#filterForm').submit();
        }
        function requiredDocument()
        {
            $('#filterForm').attr('action',"{{route('employees.requiredDocument')}}");
            $('#filterForm').submit();
        }


      $('#filter_sector_id').on('change', function(){
          var sector_id = $(this).val();                  

          if (sector_id == '') // is empty
          {
            $('#filter_department_id').prop('disabled', true); // set disable    
            $('#filter_department_id')                
                .empty()
                .append('<option value="whatever">{{trans('staff::local.departments')}}</option>');                       
          }
          else // is not empty
          {
            $('#filter_department_id').prop('disabled', false);	// set enable                  
            //using
            $.ajax({
              url:'{{route("getDepartmentsBySectorId")}}',
              type:"post",
              data: {
                _method		    : 'PUT',
                sector_id 	  : sector_id,                      
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){
                $('#filter_department_id').html(data);                      
              }
            });
          }
        }); 
</script>
@endsection
