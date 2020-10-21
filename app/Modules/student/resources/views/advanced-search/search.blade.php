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
      <div class="card-content collapse show">
        <div class="card-body">
            {{-- input search --}}
            <div class="col-md-12">
                <div class="form-group row">                
                    <div class="col-lg-10 col-md-12">
                        <input type="text" class="form-control" id="searchboxId" placeholder="{{ trans('student::local.search') }}"
                        name="input_search">                    
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <!-- search -->
                        <button type="button" onclick="find()" class="btn btn-info  btn-md">{{ trans('student::local.search') }}</button>  
                        <!-- field search -->
                        <button type="button" class="btn btn-dark  btn-md" data-toggle="modal"
                        data-target="#xlarge"> {{ trans('student::local.field_search') }}
                        </button>  
                    </div>                                   
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-lg-1 col-md-2 label-control">{{ trans('student::local.find_in') }}</label>
                    <div class="col-lg-4 col-md-10">
                        <select name="searchField" id="searchField" class="form-control select2" multiple>                
                            <option selected value="student_number">{{ trans('student::local.student_number') }}</option>
                            <option selected value="ar_student_name">{{ trans('student::local.ar_student_name') }}</option>
                            <option value="en_student_name">{{ trans('student::local.en_student_name') }}</option>
                            <option selected value="ar_father_name">{{ trans('student::local.ar_father_name') }}</option>
                            <option value="en_father_name">{{ trans('student::local.en_father_name') }}</option>
                            <option value="ar_st_name">{{ trans('student::local.father_ar_st_name') }}</option>
                            <option value="ar_nd_name">{{ trans('student::local.father_ar_nd_name') }}</option>
                            <option value="ar_rd_name">{{ trans('student::local.father_ar_rd_name') }}</option>
                            <option value="ar_th_name">{{ trans('student::local.father_ar_th_name') }}</option>
                            <option value="en_st_name">{{ trans('student::local.father_en_st_name') }}</option>
                            <option value="en_nd_name">{{ trans('student::local.father_en_nd_name') }}</option>
                            <option value="en_rd_name">{{ trans('student::local.father_en_rd_name') }}</option>
                            <option value="en_th_name">{{ trans('student::local.father_en_th_name') }}</option>
                            <option value="full_name">{{ trans('student::local.mother_full_name') }}</option>                            
                            <option value="student_id_number">{{ trans('student::local.student_id_number') }}</option>
                            <option value="id_number">{{ trans('student::local.father_id_number') }}</option>
                            <option value="id_number_m">{{ trans('student::local.id_number_m') }}</option>
                            <option selected value="mobile1">{{ trans('student::local.father_mobile1') }}</option>
                            <option value="mobile2">{{ trans('student::local.father_mobile2') }}</option>
                            <option value="mobile1_m">{{ trans('student::local.mobile1_m') }}</option>
                            <option value="mobile2_m">{{ trans('student::local.mobile2_m') }}</option>
                            <option value="submitted_name">{{ trans('student::local.submitted_name') }}</option>
                            <option value="submitted_id_number">{{ trans('student::local.submitted_id_number') }}</option>
                            <option value="submitted_mobile">{{ trans('student::local.submitted_mobile') }}</option>
                            <option value="home_phone">{{ trans('student::local.father_home_phone') }}</option>
                            <option value="email">{{ trans('student::local.father_email') }}</option>
                            <option value="job">{{ trans('student::local.father_job') }}</option>
                            <option value="qualification">{{ trans('student::local.father_qualification') }}</option>
                            <option value="facebook">{{ trans('student::local.father_facebook') }}</option>
                            <option value="whatsapp_number">{{ trans('student::local.father_whatsapp_number') }}</option>
                            <option value="street_name">{{ trans('student::local.father_street_name') }}</option>
                            <option value="state">{{ trans('student::local.father_state') }}</option>
                            <option value="home_phone_m">{{ trans('student::local.home_phone_m') }}</option>
                            <option value="job_m">{{ trans('student::local.job_m') }}</option>
                            <option value="email_m">{{ trans('student::local.email_m') }}</option>
                            <option value="qualification_m">{{ trans('student::local.qualification_m') }}</option>
                            <option value="facebook_m">{{ trans('student::local.facebook_m') }}</option>
                            <option value="whatsapp_number_m">{{ trans('student::local.whatsapp_number_m') }}</option>
                            <option value="street_name_m">{{ trans('student::local.street_name_m') }}</option>
                            <option value="state_m">{{ trans('student::local.state_m') }}</option>                                          
                        </select>                    
                    </div>
                </div>
            </div> 
            @include('student::advanced-search._filed-search')
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
                                <th>{{trans('student::local.student_image')}}</th>                                
                                <th>{{trans('student::local.student_number')}}</th>                                
                                <th>{{trans('student::local.student_name')}}</th>
                                <th>{{trans('student::local.father_name')}}</th>
                                <th>{{trans('student::local.mother_name')}}</th>
                                <th>{{trans('student::local.division')}}</th>
                                <th>{{trans('student::local.grade')}}</th>                                
                                <th>{{trans('student::local.student_type')}}</th>                                
                                <th>{{trans('student::local.religion')}}</th>                                
                                <th>{{trans('student::local.reg_type')}}</th>                                
                                <th>{{trans('student::local.registration_status')}}</th>                                
                                <th>{{trans('student::local.id_type')}}</th>                                
                                <th>{{trans('student::local.student_id_number')}}</th>                                                                                                                                
                                <th>{{trans('student::local.application_date')}}</th>                                                                
                                <th>{{trans('student::local.submitted_name')}}</th>                                                                
                                <th>{{trans('student::local.submitted_mobile')}}</th>                                
                                <th>{{trans('student::local.father_mobile1')}}</th>                                
                                <th>{{trans('student::local.father_mobile2')}}</th>                                
                                <th>{{trans('student::local.mother_mobile1')}}</th>                                
                                <th>{{trans('student::local.mother_mobile2')}}</th>                                
                                <th>{{trans('student::local.father_id_number')}}</th>                                
                                <th>{{trans('student::local.id_number_m')}}</th>                                
                                <th>{{trans('student::local.father_email')}}</th>                                
                                <th>{{trans('student::local.email_m')}}</th>                                                                                       
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
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'students.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
            columnDefs: [
                    
                    { visible: false, targets: [ 5,9,10,13,14,15,16,17,18,20,21,22,23,24 ] },
                    { orderable: false, targets: [0 ] }
                ],
            ajax:{
                    type:'POST',
                    url:'{{route("advancedSearch")}}',
                    data:function(data){
                        data._method                     = 'PUT';
                        data._token                      = '{{ csrf_token() }}';
                        // input box search vvalue
                        data.inputSearch 		         = $('#searchboxId').val().trim();

                        // start filter
                            data.student_id_type 		= $('#student_id_type').val();
                            data.gender 		        = $('#gender').val();
                            data.student_type 		    = $('#student_type').val();
                            data.reg_type 		        = $('#reg_type').val();
                            data.registration_status_id = $('#registration_status_id').val();
                            data.educational_mandate 	= $('#educational_mandate').val();
                            data.division_id 		    = $('#division_id').val();
                            data.grade_id 		        = $('#grade_id').val();
                            data.term                   = $('#term').val();
                            data.school_id 		        = $('#school_id').val();
                            data.second_lang_id 	    = $('#second_lang_id').val();
                            data.recognition 	        = $('#recognition').val();
                        // end filter

                        // find in
                            var student_number 		        = $('#searchField').val();
                            var ar_student_name 	        = $('#searchField').val();
                            var en_student_name             = $('#searchField').val();
                            var ar_father_name              = $('#searchField').val();
                            var en_father_name              = $('#searchField').val();
                            var ar_st_name 		            = $('#searchField').val();
                            var ar_nd_name 		            = $('#searchField').val();
                            var ar_rd_name 		            = $('#searchField').val();
                            var ar_th_name 		            = $('#searchField').val();
                            var en_st_name 		            = $('#searchField').val();
                            var en_nd_name 		            = $('#searchField').val();
                            var en_rd_name 	                = $('#searchField').val();
                            var en_th_name 	                = $('#searchField').val();
                            var full_name 		            = $('#searchField').val();
                            var student_id_number 		    = $('#searchField').val();
                            var id_number 		            = $('#searchField').val();
                            var id_number_m 		        = $('#searchField').val();
                            var mobile1 		            = $('#searchField').val();
                            var mobile2 		            = $('#searchField').val();
                            var mobile1_m 		            = $('#searchField').val();
                            var mobile2_m 		            = $('#searchField').val();
                            var submitted_name 		        = $('#searchField').val();
                            var submitted_id_number 		= $('#searchField').val();
                            var submitted_mobile 		    = $('#searchField').val();
                            var home_phone 		            = $('#searchField').val();
                            var email 		                = $('#searchField').val();
                            var job 		                = $('#searchField').val();
                            var qualification 		        = $('#searchField').val();
                            var facebook 		            = $('#searchField').val();
                            var whatsapp_number 		    = $('#searchField').val();
                            var street_name 		        = $('#searchField').val();
                            var state 		                = $('#searchField').val();
                            var home_phone_m 		        = $('#searchField').val();
                            var job_m 		                = $('#searchField').val();
                            var email_m 		            = $('#searchField').val();
                            var qualification_m 		    = $('#searchField').val();
                            var facebook_m 		            = $('#searchField').val();
                            var whatsapp_number_m 		    = $('#searchField').val();
                            var street_name_m 		        = $('#searchField').val();
                            var state_m 		            = $('#searchField').val();
                        // end find in

                        // set request field
                            if (student_number != null) {
                                data.field 		    = student_number;
                            }
                            if (ar_student_name != null) {
                                data.field 		    = ar_student_name;
                            }
                            if (en_student_name != null) {
                                data.field 		    = en_student_name;
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
                            if (full_name != null) {
                                data.field 		    = full_name;
                            }
                            if (student_id_number != null) {
                                data.field 		    = student_id_number;
                            }
                            if (id_number != null) {
                                data.field 		    = id_number;
                            }
                            if (id_number_m != null) {
                                data.field 		    = id_number_m;
                            }
                            if (mobile1 != null) {
                                data.field 		    = mobile1;
                            }
                            if (mobile2 != null) {
                                data.field 		    = mobile2;
                            }
                            if (mobile1_m != null) {
                                data.field 		    = mobile1_m;
                            }
                            if (mobile2_m != null) {
                                data.field 		    = mobile2_m;
                            }
                            if (submitted_name != null) {
                                data.field 		    = submitted_name;
                            }
                            if (submitted_id_number != null) {
                                data.field 		    = submitted_id_number;
                            }
                            if (submitted_mobile != null) {
                                data.field 		    = submitted_mobile;
                            }
                            if (home_phone != null) {
                                data.field 		    = home_phone;
                            }
                            if (email != null) {
                                data.field 		    = email;
                            }
                            if (job != null) {
                                data.field 		    = job;
                            }
                            if (qualification != null) {
                                data.field 		    = qualification;
                            }
                            if (facebook != null) {
                                data.field 		    = facebook;
                            }
                            if (whatsapp_number != null) {
                                data.field 		    = whatsapp_number;
                            }
                            if (street_name != null) {
                                data.field 		    = street_name;
                            }
                            if (state != null) {
                                data.field 		    = state;
                            }
                            if (home_phone_m != null) {
                                data.field 		    = home_phone_m;
                            }
                            if (job_m != null) {
                                data.field 		    = job_m;
                            }
                            if (email_m != null) {
                                data.field 		    = email_m;
                            }
                            if (qualification_m != null) {
                                data.field 		    = qualification_m;
                            }
                            if (facebook_m != null) {
                                data.field 		    = facebook_m;
                            }
                            if (whatsapp_number_m != null) {
                                data.field 		    = whatsapp_number_m;
                            }
                            if (street_name_m != null) {
                                data.field 		    = street_name_m;
                            }  
                            if (state_m != null) {
                                data.field 		    = state_m;
                            }                                  
                            
                        // end set request field
                    }
                },
            columns: [
                {data: 'check',                 name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'student_image',         name: 'student_image'}, 
                {data: 'student_number',        name: 'student_number'}, 
                {data: 'student_name',          name: 'student_name'},
                {data: 'father_name',           name: 'father_name'},
                {data: 'full_name',             name: 'full_name'}, 
                {data: 'division',              name: 'division'},                        
                {data: 'grade',                 name: 'grade'},                        
                {data: 'student_type',          name: 'student_type'},                        
                {data: 'religion',              name: 'religion'},                        
                {data: 'reg_type',              name: 'reg_type'},                        
                {data: 'registration_status',   name: 'registration_status'},                        
                {data: 'student_id_type',       name: 'student_id_type'},                        
                {data: 'student_id_number',     name: 'student_id_number'},                        
                {data: 'application_date',      name: 'application_date'},                        
                {data: 'submitted_name',        name: 'submitted_name'},                        
                {data: 'submitted_mobile',      name: 'submitted_mobile'},                        
                {data: 'mobile1',               name: 'mobile1'},                        
                {data: 'mobile2',               name: 'mobile2'},                        
                {data: 'mobile1_m',             name: 'mobile1_m'},                        
                {data: 'mobile2_m',             name: 'mobile2_m'},                        
                {data: 'id_number',             name: 'id_number'},                        
                {data: 'id_number_m',           name: 'id_number_m'},                        
                {data: 'email',                 name: 'email'},                        
                {data: 'email_m',               name: 'email_m'},                        
            ],
            @include('layouts.backEnd.includes.datatables._datatableLang')
        });
            @include('layouts.backEnd.includes.datatables._multiSelect')
        };                
                  
    </script>
    @include('layouts.backEnd.includes.datatables._datatable')
@endsection

 