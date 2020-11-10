@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
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
            {{-- input search --}}
            <div class="col-md-12">
                <div class="form-group row">                
                    <div class="col-lg-10 col-md-12">
                        <input type="text" class="form-control" id="searchboxId" placeholder="{{ trans('staff::local.search') }}"
                        name="input_search">                    
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <!-- search -->
                        <button type="button" onclick="find()" class="btn btn-info  btn-md">{{ trans('staff::local.search') }}</button>  
                        <!-- field search -->
                        <button type="button" class="btn btn-dark  btn-md" data-toggle="modal"
                        data-target="#xlarge"> {{ trans('staff::local.field_search') }}
                        </button>  
                    </div>                                   
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-lg-1 col-md-2 label-control">{{ trans('staff::local.find_in') }}</label>
                    <div class="col-lg-4 col-md-10">
                        <select name="searchField" id="searchField" class="form-control select2" multiple>                
                            <option selected value="attendance_id">{{ trans('staff::local.attendance_id') }}</option>                            
                            <option value="ar_st_name">{{ trans('staff::local.ar_st_name') }}</option>
                            <option value="ar_nd_name">{{ trans('staff::local.ar_nd_name') }}</option>
                            <option value="ar_rd_name">{{ trans('staff::local.ar_rd_name') }}</option>
                            <option value="ar_th_name">{{ trans('staff::local.ar_th_name') }}</option>
                            <option value="en_st_name">{{ trans('staff::local.en_st_name') }}</option>
                            <option value="en_nd_name">{{ trans('staff::local.en_nd_name') }}</option>
                            <option value="en_rd_name">{{ trans('staff::local.en_rd_name') }}</option>
                            <option value="en_th_name">{{ trans('staff::local.en_th_name') }}</option>                                                        
                            <option selected value="mobile1">{{ trans('staff::local.mobile1') }}</option>
                            <option selected value="mobile2">{{ trans('staff::local.mobile2') }}</option>
                            <option value="address">{{ trans('staff::local.address') }}</option>
                            <option value="national_id">{{ trans('staff::local.national_id') }}</option>
                            <option value="hiring_date">{{ trans('staff::local.hiring_date') }}</option>
                            <option value="contract_date">{{ trans('staff::local.contract_date') }}</option>
                            <option value="contract_end_date">{{ trans('staff::local.contract_end_date') }}</option>
                            <option value="institution">{{ trans('staff::local.institution') }}</option>
                            <option value="qualification">{{ trans('staff::local.qualification') }}</option>
                            <option value="social_insurance_num">{{ trans('staff::local.social_insurance_num') }}</option>
                            <option value="social_insurance_date">{{ trans('staff::local.social_insurance_date') }}</option>
                            <option value="medical_insurance_num">{{ trans('staff::local.medical_insurance_num') }}</option>
                            <option value="medical_insurance_date">{{ trans('staff::local.medical_insurance_date') }}</option>
                            <option value="leave_date">{{ trans('staff::local.leave_date') }}</option>
                            <option value="salary">{{ trans('staff::local.salary') }}</option>
                            <option value="salary_bank_name">{{ trans('staff::local.salary_bank_name') }}</option>
                            <option value="bank_account">{{ trans('staff::local.bank_account') }}</option>
                            
                        </select>                    
                    </div>
                </div>
            </div> 
            @include('staff::employees.includes._filed-search')
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row hidden" id="result">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
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
                                <th>{{trans('staff::local.employee_image')}}</th>
                                <th>{{trans('staff::local.attendance_id')}}</th>                                
                                <th>{{trans('staff::local.employee_name')}}</th>
                                <th>{{trans('staff::local.mobile')}}</th>
                                <th>{{trans('staff::local.working_data')}}</th>
                                <th>{{trans('staff::local.position')}}</th>                                
                                <th>{{trans('staff::local.address')}}</th>                                
                                <th>{{trans('staff::local.national_id')}}</th>                                
                                <th>{{trans('staff::local.hiring_date')}}</th>                                
                                <th>{{trans('staff::local.contract_date')}}</th>                                
                                <th>{{trans('staff::local.contract_end_date')}}</th>                                
                                <th>{{trans('staff::local.institution')}}</th>                                
                                <th>{{trans('staff::local.qualification')}}</th>                                
                                <th>{{trans('staff::local.social_insurance_num')}}</th>                                
                                <th>{{trans('staff::local.social_insurance_date')}}</th>                                
                                <th>{{trans('staff::local.medical_insurance_num')}}</th>                                
                                <th>{{trans('staff::local.medical_insurance_date')}}</th>                                
                                <th>{{trans('staff::local.leave_date')}}</th>                                
                                <th>{{trans('staff::local.salary')}}</th>                                
                                <th>{{trans('staff::local.salary_bank_name')}}</th>                                
                                <th>{{trans('staff::local.bank_account')}}</th>                                
                                <th>{{trans('staff::local.edit')}}</th>                                                                                     
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
        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                find();
            }
        });    
       function find()
        {   $('#result').removeClass('hidden');
            $('#dynamic-table').DataTable().destroy();
            var myTable = $('#dynamic-table').DataTable({
            @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'employees.destroy'])
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
            columnDefs: [
                    
                    { visible: false, targets: [ 7,8,9,10,11,12,13,14,15,16,17,18,19,20,21 ] },
                    { orderable: false, targets: [0 ] }
                ],
            ajax:{
                    type:'POST',
                    url:'{{route("employees.advancedSearch")}}',
                    data:function(data){
                        data._method                     = 'PUT';
                        data._token                      = '{{ csrf_token() }}';
                        // input box search vvalue
                        data.inputSearch 		         = $('#searchboxId').val().trim();

                        // start filter
                            data.sector_id 		        = $('#sector_id').val();
                            data.department_id 		    = $('#department_id').val();
                            data.section_id 		    = $('#section_id').val();
                            data.position_id 		    = $('#position_id').val();
                            data.timetable_id           = $('#timetable_id').val();
                            data.leaved 	            = $('#leaved').val();
                            data.has_contract 		    = $('#has_contract').val();
                            data.contract_type 	        = $('#contract_type').val();
                            data.salary_mode 		    = $('#salary_mode').val();
                            data.salary_suspend         = $('#salary_suspend').val();
                            data.social_insurance 		= $('#social_insurance').val();
                            data.medical_insurance 	    = $('#medical_insurance').val();
                        // end filter

                        // find in
                            var attendance_id 		        = $('#searchField').val();                            
                            var ar_st_name 		            = $('#searchField').val();
                            var ar_nd_name 		            = $('#searchField').val();
                            var ar_rd_name 		            = $('#searchField').val();
                            var ar_th_name 		            = $('#searchField').val();
                            var en_st_name 		            = $('#searchField').val();
                            var en_nd_name 		            = $('#searchField').val();
                            var en_rd_name 	                = $('#searchField').val();
                            var en_th_name 	                = $('#searchField').val();
                            var email 		                = $('#searchField').val();                            
                            var mobile1 		            = $('#searchField').val();
                            var mobile2 		            = $('#searchField').val();
                            var address 		            = $('#searchField').val();
                            var national_id 		        = $('#searchField').val();
                            var hiring_date 		        = $('#searchField').val();
                            var contract_date 		        = $('#searchField').val();
                            var contract_end_date 		    = $('#searchField').val();
                            var institution 		        = $('#searchField').val();
                            var qualification 		        = $('#searchField').val();
                            var social_insurance_num 		= $('#searchField').val();
                            var social_insurance_date 		= $('#searchField').val();
                            var medical_insurance_num 		= $('#searchField').val();
                            var medical_insurance_date 		= $('#searchField').val();
                            var leave_date 		            = $('#searchField').val();
                            var salary 		                = $('#searchField').val();
                            var salary_bank_name            = $('#searchField').val();
                            var bank_account                = $('#searchField').val();
                            
                        // end find in

                        // set request field
                            if (attendance_id != null) {
                                data.field 		    = attendance_id;
                            }                            
                            if (ar_st_name != null) {
                                data.field 		    = ar_st_name;
                            }
                            if (ar_nd_name != null) {
                                data.field 		    = ar_nd_name;
                            }
                            if (ar_rd_name != null) {
                                data.field 		    = ar_rd_name;
                            }
                            if (ar_th_name != null) {
                                data.field 		    = ar_th_name;
                            }
                            if (en_st_name != null) {
                                data.field 		    = en_st_name;
                            }
                            if (en_nd_name != null) {
                                data.field 		    = en_nd_name;
                            }
                            if (en_rd_name != null) {
                                data.field 		    = en_rd_name;
                            }
                            if (en_th_name != null) {
                                data.field 		    = en_th_name;
                            }
                            if (email != null) {
                                data.field 		    = email;
                            }                            
                            if (mobile1 != null) {
                                data.field 		    = mobile1;
                            }
                            if (mobile2 != null) {
                                data.field 		    = mobile2;
                            }
                            if (address != null) {
                                data.field 		    = address;
                            }
                            if (national_id != null) {
                                data.field 		    = national_id;
                            }
                            if (hiring_date != null) {
                                data.field 		    = hiring_date;
                            }
                            if (contract_date != null) {
                                data.field 		    = contract_date;
                            }
                            if (contract_end_date != null) {
                                data.field 		    = contract_end_date;
                            }
                            if (institution != null) {
                                data.field 		    = institution;
                            }
                            if (qualification != null) {
                                data.field 		    = qualification;
                            }
                            if (social_insurance_num != null) {
                                data.field 		    = social_insurance_num;
                            }
                            if (social_insurance_date != null) {
                                data.field 		    = social_insurance_date;
                            }
                            if (medical_insurance_num != null) {
                                data.field 		    = medical_insurance_num;
                            }
                            if (medical_insurance_date != null) {
                                data.field 		    = medical_insurance_date;
                            }
                            if (leave_date != null) {
                                data.field 		    = leave_date;
                            }
                            if (salary != null) {
                                data.field 		    = salary;
                            }
                            if (salary_bank_name != null) {
                                data.field 		    = salary_bank_name;
                            }
                            if (bank_account != null) {
                                data.field 		    = bank_account;
                            }
                            
                            
                        // end set request field
                    }
                },
            columns: [
                {data: 'check',                         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',                   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'employee_image',                name: 'employee_image'},              
                {data: 'attendance_id',                 name: 'attendance_id'},              
                {data: 'employee_name',                 name: 'employee_name'},
                {data: 'mobile',                        name: 'mobile'},
                {data: 'working_data',                  name: 'working_data'},
                {data: 'position',                      name: 'position'},              
                {data: 'address',                       name: 'address'},              
                {data: 'national_id',                   name: 'national_id'},              
                {data: 'hiring_date',                   name: 'hiring_date'},              
                {data: 'contract_date',                 name: 'contract_date'},              
                {data: 'contract_end_date',             name: 'contract_end_date'},              
                {data: 'institution',                   name: 'institution'},              
                {data: 'qualification',                 name: 'qualification'},              
                {data: 'social_insurance_num',          name: 'social_insurance_num'},              
                {data: 'social_insurance_date',         name: 'social_insurance_date'},              
                {data: 'medical_insurance_num',         name: 'medical_insurance_num'},              
                {data: 'medical_insurance_date',        name: 'medical_insurance_date'},              
                {data: 'leave_date',                    name: 'leave_date'},              
                {data: 'salary',                        name: 'salary'},              
                {data: 'salary_bank_name',              name: 'salary_bank_name'},              
                {data: 'bank_account',                  name: 'bank_account'},              
                {data: 'action', 	                    name: 'action', orderable: false, searchable: false},                                   
            ],
            @include('layouts.backEnd.includes.datatables._datatableLang')
        });
            @include('layouts.backEnd.includes.datatables._multiSelect')
        }; 

        $('#sector_id').on('change', function(){
                var sector_id = $(this).val();                  

                if (sector_id == '') // is empty
                {
                  $('#department_id').prop('disabled', true); // set disable                  
                }
                else // is not empty
                {
                  $('#department_id').prop('disabled', false);	// set enable                  
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
                      $('#department_id').html(data);                      
                    }
                  });
                }
          });        
    </script>
    @include('layouts.backEnd.includes.datatables._datatable')
@endsection

 