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
            <li class="breadcrumb-item"><a href="{{route('employees.index')}}">{{ trans('staff::local.employees') }}</a></li>
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
              <div class="col-md-12">
                  <h2 class="mb-2">
                    @if (session('lang')=='ar')
                        {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                    @else
                        {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$employee->en_th_name}}
                    @endif                   
                    
                </h2> 
              </div>
              <div class="col-md-12">
                <div class="btn-group">                    
                    <a href="{{route('employees.edit',$employee->id)}}" class="mb-1 btn btn-warning white"><i class="la la-edit"></i> {{ trans('staff::local.edit') }}</a>                    
                    <a href="#" onclick="deduction({{$employee->id}})" class="mb-1 btn btn-danger white"><i class="la la-gavel"></i> {{ trans('staff::local.deductions') }}</a>                                        
                    <a href="#" onclick="loans({{$employee->id}})" class="mb-1 btn btn-dark white"><i class="la la-minus-square"></i> {{ trans('staff::local.loans') }}</a>                                        
                    <a href="#" onclick="vacations({{$employee->id}})" class="mb-1 btn btn-info white"><i class="la la-umbrella"></i> {{ trans('staff::local.vacations') }}</a>                                        
                    <a href="#" onclick="permissions({{$employee->id}})" class="mb-1 btn btn-purple white"><i class="la la-road"></i> {{ trans('staff::local.leave_requests') }}</a>                                        
                    <a href="#" onclick="payrolls({{$employee->id}})" class="mb-1 btn btn-primary white"><i class="la la-monry"></i> {{ trans('staff::local.payrolls') }}</a>                                        
                </div>
            </div>
            @if(session('error'))
                <h4 class="red"> {{session('error')}}</h4>
            @endif              
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
      <div class="card div-image">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-md-5">      
                    @empty($employee->employee_image)
                    @php
                        $path_image = $employee->gender == trans('staff::local.male') ? 'images/website/male.png' : 'images/website/female.png'
                    @endphp
                    <img style="width : 100%" class="editable img-responsive student-image-profile" alt="Alex's Avatar" id="avatar2" 
                    src="{{asset($path_image)}}" />
                    @else
                    <img class="editable img-responsive student-image-profile" alt="Alex's Avatar" id="avatar2" 
                    src="{{asset('images/employeesImages/'.$employee->employee_image)}}" />
                    @endempty          
                </div>
                <div class="col-lg-12 col-md-6 mt-lg-1">
                    <h6><strong>{{ trans('staff::local.created_by') }} : {{$employee->admin->name}}</strong></h6>
                    <h6><strong>{{ trans('staff::local.created_at') }} : </strong></h6>{{empty($employee->created_at) ? trans('staff::local.imported') : $employee->created_at}}
                    <h6><strong>{{ trans('staff::local.updated_at') }} : </strong></h6>{{$employee->updated_at}}                    
                </div>                
              </div>                             
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
      <div class="card" style="min-height: 615px">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-md-12">                
                    <div class="nav-vertical">
                        <ul class="nav nav-tabs nav-left nav-border-left">
                          <li class="nav-item">
                            <a class="nav-link active" id="baseVerticalLeft1-tab1" data-toggle="tab" aria-controls="tabVerticalLeft11"
                            href="#tabVerticalLeft11" aria-expanded="true">{{ trans('staff::local.basic_data') }}</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab2" data-toggle="tab" aria-controls="tabVerticalLeft12"
                            href="#tabVerticalLeft12" aria-expanded="false">{{ trans('staff::local.personal_data') }}</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab3" data-toggle="tab" aria-controls="tabVerticalLeft13"
                            href="#tabVerticalLeft13" aria-expanded="false">{{ trans('staff::local.working_data') }}</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab4" data-toggle="tab" aria-controls="tabVerticalLeft14"
                            href="#tabVerticalLeft14" aria-expanded="false">{{ trans('staff::local.attendance') }}</a>
                          </li>   
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab5" data-toggle="tab" aria-controls="tabVerticalLeft15"
                            href="#tabVerticalLeft15" aria-expanded="false">{{ trans('staff::local.contracts') }}</a>
                          </li>                                                  
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab6" data-toggle="tab" aria-controls="tabVerticalLeft16"
                            href="#tabVerticalLeft16" aria-expanded="false">{{ trans('staff::local.previous_experience') }}</a>
                          </li> 
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab7" data-toggle="tab" aria-controls="tabVerticalLeft17"
                            href="#tabVerticalLeft17" aria-expanded="false">{{ trans('staff::local.education') }}</a>
                          </li>                               
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab8" data-toggle="tab" aria-controls="tabVerticalLeft18"
                            href="#tabVerticalLeft18" aria-expanded="false">{{ trans('staff::local.salary') }}</a>
                          </li>                
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab9" data-toggle="tab" aria-controls="tabVerticalLeft19"
                            href="#tabVerticalLeft19" aria-expanded="false">{{ trans('staff::local.skills') }}</a>
                          </li>   
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab10" data-toggle="tab" aria-controls="tabVerticalLeft20"
                            href="#tabVerticalLeft20" aria-expanded="false">{{ trans('staff::local.required_documents') }}</a>
                          </li>  
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab11" data-toggle="tab" aria-controls="tabVerticalLeft21"
                            href="#tabVerticalLeft21" aria-expanded="false">{{ trans('staff::local.insurance') }}</a>
                          </li>                
                          <li class="nav-item">
                            <a class="nav-link" id="baseVerticalLeft1-tab12" data-toggle="tab" aria-controls="tabVerticalLeft22"
                            href="#tabVerticalLeft22" aria-expanded="false">{{ trans('staff::local.leave_work') }}</a>
                          </li>                                                      
                        </ul>
                        <div class="tab-content px-1">
                            {{-- basic data --}}
                            <div role="tabpanel" class="tab-pane active" id="tabVerticalLeft11" aria-expanded="true"
                                aria-labelledby="baseVerticalLeft1-tab1">
                                <h4 class="purple">{{ trans('staff::local.basic_data') }}</h4>
                                <div class="row" style="margin-left: 0;">
                                  <div class="col-lg-2 col-md-3">
                                      <div class="form-group">
                                      <label>{{ trans('staff::local.attendance_id') }}</label>
                                      <input type="number" min="0" class="form-control " disabled value="{{old('attendance_id',$employee->attendance_id)}}"                             
                                          name="attendance_id" >   
                                      
                                      </div>
                                  </div>
                                  <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                    <label>{{ trans('admin.username') }}</label>
                                    <input type="text" class="form-control " disabled   value="{{$employee->employee_user->username}}">   
                                    
                                    </div>
                                </div>
                                </div>
                    
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.ar_st_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('ar_st_name',$employee->ar_st_name)}}" 
                                          placeholder="{{ trans('staff::local.ar_st_name') }}"
                                            name="ar_st_name" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.ar_nd_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('ar_nd_name',$employee->ar_nd_name)}}" 
                                          placeholder="{{ trans('staff::local.ar_nd_name') }}"
                                            name="ar_nd_name" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.ar_rd_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('ar_rd_name',$employee->ar_rd_name)}}" 
                                          placeholder="{{ trans('staff::local.ar_rd_name') }}"
                                            name="ar_rd_name">                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.ar_th_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('ar_th_name',$employee->ar_th_name)}}" 
                                          placeholder="{{ trans('staff::local.ar_th_name') }}"
                                            name="ar_th_name">                                            
                                        </div>
                                    </div>
                                </div> 
                    
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.en_st_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('en_st_name',$employee->en_st_name)}}" 
                                          placeholder="{{ trans('staff::local.en_st_name') }}"
                                            name="en_st_name" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.en_nd_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('en_nd_name',$employee->en_nd_name)}}" 
                                          placeholder="{{ trans('staff::local.en_nd_name') }}"
                                            name="en_nd_name" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.en_rd_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('en_rd_name',$employee->en_rd_name)}}" 
                                          placeholder="{{ trans('staff::local.en_rd_name') }}"
                                            name="en_rd_name">                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.en_th_name') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('en_th_name',$employee->en_th_name)}}" 
                                          placeholder="{{ trans('staff::local.en_th_name') }}"
                                            name="en_th_name">                                            
                                        </div>
                                    </div>
                                </div>   
                    
                                <div class="row" style="margin-left: 0;">
                                  @php
                                      $national_id = $employee->national_id == '' || $employee->national_id == null ? 0 : $employee->national_id;
                                  @endphp
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.national_id') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('national_id',$national_id)}}" 
                                          placeholder="{{ trans('staff::local.national_id') }}"
                                            name="national_id">
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.email') }}</label>
                                          <input type="text" class="form-control " disabled value="{{old('email',$employee->email)}}" 
                                          placeholder="{{ trans('staff::local.email') }}"
                                            name="email">                                            
                                        </div>
                                    </div>
                                </div>  
                    
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.mobile1') }}</label>
                                          <input type="number" class="form-control " disabled value="{{old('mobile1',$employee->mobile1)}}" 
                                          placeholder="{{ trans('staff::local.mobile1') }}"
                                            name="mobile1">                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.mobile2') }}</label>
                                          <input type="number" class="form-control " disabled value="{{old('mobile2',$employee->mobile2)}}" 
                                          placeholder="{{ trans('staff::local.mobile2') }}"
                                            name="mobile2">                                            
                                        </div>
                                    </div>
                                </div> 
                    
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-2 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.salary') }}</label>
                                          <input type="number" min="0" class="form-control " disabled value="{{old('salary',$employee->salary)}}" 
                                          placeholder="{{ trans('staff::local.salary') }}"
                                            name="salary" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.bus_value') }}</label>
                                          <input type="number" min="0" class="form-control " disabled value="{{old('bus_value',$employee->bus_value)}}" 
                                          placeholder="{{ trans('staff::local.bus_value') }}"
                                            name="bus_value">                                            
                                        </div>
                                    </div>      
                                    @php
                                        $leave_balance = $employee->leave_balance == '' || $employee->leave_balance == null ? 0 : $employee->leave_balance;
                                    @endphp
                                    <div class="col-lg-2 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.leave_balance') }}</label>
                                          <input type="number" min="0" class="form-control"  disabled value="{{old('leave_balance',$leave_balance)}}" 
                                          placeholder="{{ trans('staff::local.leave_balance') }}"
                                            name="leave_balance">  
                                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.vacation_allocated') }}</label>
                                          <input type="number" min="0" class="form-control " disabled  value="{{old('vacation_allocated',$employee->vacation_allocated)}}" 
                                          placeholder="{{ trans('staff::local.vacation_allocated') }}"
                                            name="vacation_allocated">                                            
                                        </div>
                                    </div>
                                </div>  
                                <div class="row" style="margin-left: 0;">
                                  <div class="col-lg-2 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.insurance_value') }}</label>
                                        <input type="number" min="0" class="form-control" disabled value="{{old('insurance_value',$employee->insurance_value)}}" 
                                        placeholder="{{ trans('staff::local.insurance_value') }}"
                                          name="insurance_value">                                          
                                      </div>
                                  </div>
                                  <div class="col-lg-2 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.tax_value') }}</label>
                                        <input type="number" min="0" class="form-control" disabled value="{{old('tax_value',$employee->tax_value)}}" 
                                        placeholder="{{ trans('staff::local.tax_value') }}"
                                          name="tax_value">                                            
                                      </div>
                                  </div>      
                                </div>                                                                
                            </div>
                            {{-- personal data --}}
                            <div class="tab-pane" id="tabVerticalLeft12" aria-labelledby="baseVerticalLeft1-tab2">
                                <h4 class="purple">{{ trans('staff::local.personal_data') }}</h4>
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.dob') }}</label>
                                          <input type="date" class="form-control " disabled value="{{old('dob',$employee->dob)}}"                                           
                                            name="dob">                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.gender') }}</label>
                                          <select name="gender" class="form-control" disabled>                        
                                            <option {{old('gender',$employee->gender) =='male' || 
                                            old('gender',$employee->gender) == trans('staff::local.male')? 'selected':'' }} value="male">{{ trans('staff::local.male') }}</option>    
                                            <option {{old('gender',$employee->gender) =='female'||
                                            old('gender',$employee->gender) == trans('staff::local.female')? 'selected':'' }} value="female">{{ trans('staff::local.female') }}</option>    
                                          </select>                                          
                                        </div>
                                    </div>
                                </div> 
                    
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.religion') }}</label>
                                          <select name="religion" class="form-control" disabled>
                                            
                                            <option {{old('religion',$employee->religion) =='muslim' ||
                                            old('religion',$employee->religion) == trans('staff::local.muslim') ? 'selected':'' }} value="muslim">{{ trans('staff::local.muslim') }}</option>    
                                            <option {{old('religion',$employee->religion) =='christian' ||
                                             old('religion',$employee->religion) == trans('staff::local.christian')  ? 'selected':'' }} value="christian">{{ trans('staff::local.christian') }}</option>    
                                          </select>                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.native') }}</label>
                                          <select name="native" class="form-control" disabled>
                                            
                                            <option {{old('native',$employee->native) =='Arabic' ||
                                            old('native',$employee->native) == trans('staff::local.arabic') ? 'selected':'' }} value="Arabic">{{ trans('staff::local.arabic') }}</option>    
                                            <option {{old('native',$employee->native) =='English' ||
                                            old('native',$employee->native) == trans('staff::local.english')? 'selected':'' }} value="English">{{ trans('staff::local.english') }}</option>        
                                            <option {{old('native',$employee->native) =='French' ||
                                            old('native',$employee->native) == trans('staff::local.french')? 'selected':'' }} value="French">{{ trans('staff::local.french') }}</option>        
                                            <option {{old('native',$employee->native) =='German' ||
                                            old('native',$employee->native) == trans('staff::local.german')? 'selected':'' }} value="German">{{ trans('staff::local.german') }}</option>        
                                            <option {{old('native',$employee->native) =='Italy' ||
                                            old('native',$employee->native) == trans('staff::local.italy')? 'selected':'' }} value="Italy">{{ trans('staff::local.italy') }}</option>        
                                          </select>                                          
                                        </div>
                                    </div>
                                </div> 
                    
                                <div class="row" style="margin-left: 0;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.marital_status') }}</label>
                                          <select name="marital_status" class="form-control" disabled>
                                            
                                            <option {{old('marital_status',$employee->marital_status) =='Single' ||
                                             old('marital_status',$employee->marital_status) == trans('staff::local.single') ? 'selected':'' }} value="Single">{{ trans('staff::local.single') }}</option>    
                                            <option {{old('marital_status',$employee->marital_status) =='Married' ||
                                            old('marital_status',$employee->marital_status) == trans('staff::local.married')? 'selected':'' }} value="Married">{{ trans('staff::local.married') }}</option>        
                                            <option {{old('marital_status',$employee->marital_status) =='Separated' ||
                                            old('marital_status',$employee->marital_status) == trans('staff::local.separated')? 'selected':'' }} value="Separated">{{ trans('staff::local.separated') }}</option>        
                                            <option {{old('marital_status',$employee->marital_status) =='Divorced' ||
                                            old('marital_status',$employee->marital_status) == trans('staff::local.divorced')? 'selected':'' }} value="Divorced">{{ trans('staff::local.divorced') }}</option>        
                                            <option {{old('marital_status',$employee->marital_status) =='Widowed' ||
                                            old('marital_status',$employee->marital_status) == trans('staff::local.widowed')? 'selected':'' }} value="Widowed">{{ trans('staff::local.widowed') }}</option>           
                                          </select>                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                          <label>{{ trans('staff::local.military_service') }}</label>
                                          <select name="military_service" class="form-control" disabled>
                                            <option value="">{{ trans('staff::local.select') }}</option>    
                                            <option {{old('military_service',$employee->military_service) =='Exempted' ||
                                            old('military_service',$employee->military_service) == trans('staff::local.exempted')? 'selected':'' }} value="Exempted">{{ trans('staff::local.exempted') }}</option>        
                                            <option {{old('military_service',$employee->military_service) =='Finished' ||
                                            old('military_service',$employee->military_service) == trans('staff::local.finished')? 'selected':'' }} value="Finished">{{ trans('staff::local.finished') }}</option>               
                                          </select>                                          
                                        </div>
                                    </div>
                                </div> 
                    
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group row">
                                        <label>{{ trans('staff::local.address') }}</label>                                 
                                         <textarea disabled name="address" class="form-control" disable cols="30" rows="5">{{old('address',$employee->address)}}</textarea>                                         
                                    </div>
                                </div>
                    
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group row">
                                        <label>{{ trans('staff::local.health_details') }}</label>                                 
                                         <textarea disabled name="health_details" class="form-control" disable cols="30" rows="5">{{old('health_details',$employee->health_details)}}</textarea>                                         
                                    </div>
                                </div>
                            </div>
                            {{-- working data --}}
                            <div class="tab-pane" id="tabVerticalLeft13" aria-labelledby="baseVerticalLeft1-tab3">
                                <h4 class="purple">{{ trans('staff::local.working_data') }}</h4>
                                <div class="row" style="margin-left: 0;">
                                  <div class="col-lg-3 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.hiring_date') }}</label>
                                        <input type="date" class="form-control " disabled value="{{old('hiring_date',$employee->hiring_date)}}"                                           
                                          name="hiring_date">                                            
                                      </div>
                                  </div>
                                  <div class="col-lg-3 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.direct_manager_id') }}</label>
                                        <select name="direct_manager_id" class="form-control select2" disabled>
                                          <option value="">{{ trans('staff::local.select') }}</option>    
                                              
                                        </select>                                          
                                      </div>
                                  </div>
                                </div> 
                    
                                <div class="row" style="margin-left: 0;">
                                  <div class="col-lg-3 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.sector_id') }}</label>
                                        <select id="sector_id" name="sector_id" class="form-control select2" disabled>
                                          <option value="">{{ trans('staff::local.select') }}</option>    
                                          @foreach ($sectors as $sector)
                                              <option {{old('sector_id',$employee->sector_id) == $sector->id ?'selected' : ''}} value="{{$sector->id}}">
                                              {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}</option>
                                          @endforeach
                                        </select>                                             
                                      </div>
                                  </div>
                                  <div class="col-lg-3 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.department_id') }}</label>
                                        <select id="department_id" name="department_id" class="form-control select2" disabled>
                                          <option value="">{{ trans('staff::local.select') }}</option>    
                                            @foreach ($departments as $department)
                                                <option {{old('department_id',$employee->department_id) == $department->id ?'selected' : ''}} value="{{$department->id}}">
                                                {{session('lang') == 'ar' ? $department->ar_department:$department->en_department}}</option>
                                            @endforeach
                                        </select>                                          
                                      </div>
                                  </div>
                                </div>
                                <div class="row" style="margin-left: 0;">
                                  <div class="col-lg-3 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.section_id') }}</label>
                                        <select name="section_id" class="form-control select2" disabled>
                                          <option value="">{{ trans('staff::local.select') }}</option>    
                                            @foreach ($sections as $section)
                                                <option {{old('section_id',$employee->section_id) == $section->id ?'selected' : ''}} value="{{$section->id}}">
                                                {{session('lang') == 'ar' ? $section->ar_section:$section->en_section}}</option>
                                            @endforeach
                                        </select>                                             
                                      </div>
                                  </div>
                                  <div class="col-lg-3 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('staff::local.position_id') }}</label>
                                        <select name="position_id" class="form-control select2" disabled>
                                          <option value="">{{ trans('staff::local.select') }}</option>    
                                            @foreach ($positions as $position)
                                                <option {{old('position_id',$employee->position_id) == $position->id ?'selected' : ''}} value="{{$position->id}}">
                                                {{session('lang') == 'ar' ? $position->ar_position:$position->en_position}}</option>
                                            @endforeach
                                        </select>                                          
                                      </div>
                                  </div>
                                </div>  
                            </div>
                            {{-- attendance --}}
                            <div class="tab-pane" id="tabVerticalLeft14" aria-labelledby="baseVerticalLeft1-tab4">
                              <h4 class="purple">{{ trans('staff::local.attendance') }}</h4>                              
                              <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                  <label>{{ trans('staff::local.timetable_id') }}</label>
                                  <select name="timetable_id" class="form-control" disabled>
                                    <option value="">{{ trans('staff::local.select') }}</option>    
                                      @foreach ($timetables as $timetable)
                                          <option  {{old('timetable_id',$employee->timetable_id) == $timetable->id ?'selected' : ''}} value="{{$timetable->id}}">
                                          {{session('lang') == 'ar' ? $timetable->ar_timetable:$timetable->en_timetable}}</option>
                                      @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                  <label>{{ trans('staff::local.holiday_id') }}</label>
                                  <ul style="list-style: none" id="holiday_id">
                        
                                  </ul>
                                </div>
                              </div>
                            </div>
                            {{-- contracts --}}
                            <div class="tab-pane" id="tabVerticalLeft15" aria-labelledby="baseVerticalLeft1-tab5">
                              <h4 class="purple">{{ trans('staff::local.contracts') }}</h4>                              
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.has_contract') }}</label>
                                      <select name="has_contract" class="form-control" disabled>
                                        
                                          <option {{old('has_contract',$employee->has_contract) =='No' ||
                                          old('has_contract',$employee->has_contract) == trans('staff::local.no') ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                                        <option {{old('has_contract',$employee->has_contract) =='Yes'  ||
                                        old('has_contract',$employee->has_contract) == trans('staff::local.yes')? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                      </select>                                             
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.contract_type') }}</label>
                                      <select name="contract_type" class="form-control" disabled>
                                        
                                        <option {{old('contract_type',$employee->contract_type) =='Full Time' ||
                                        old('contract_type',$employee->contract_type) == trans('staff::local.full_Time') ? 'selected':'' }} value="Full Time">{{ trans('staff::local.full_Time') }}</option>                                            
                                        <option {{old('contract_type',$employee->contract_type) =='Part Time' ||
                                        old('contract_type',$employee->contract_type) == trans('staff::local.part_Time') ? 'selected':'' }} value="Part Time">{{ trans('staff::local.part_Time') }}</option>                                                
                                      </select>                                          
                                    </div>
                                </div>
                              </div> 
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.contract_date') }}</label>
                                      <input type="date" class="form-control " disabled value="{{old('contract_date',$employee->contract_date)}}"                                           
                                        name="contract_date">                                            
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.contract_end_date') }}</label>
                                      <input type="date" class="form-control " disabled value="{{old('contract_end_date',$employee->contract_end_date)}}"                                           
                                        name="contract_end_date">                                         
                                    </div>
                                </div>
                              </div>                               
                            </div>  
                            {{-- previous_experience --}}
                            <div class="tab-pane" id="tabVerticalLeft16" aria-labelledby="baseVerticalLeft1-tab6">
                              <h4 class="purple">{{ trans('staff::local.previous_experience') }}</h4>
                              
                              <div class="col-lg-6 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.previous_experience') }}</label>                                 
                                     <textarea disabled name="previous_experience" class="form-control" cols="30" rows="5">{{old('previous_experience',$employee->previous_experience)}}</textarea>                                         
                                </div>
                              </div>
                            </div>      
                            {{-- education --}}
                            <div class="tab-pane" id="tabVerticalLeft17" aria-labelledby="baseVerticalLeft1-tab7">
                              <h4 class="purple">{{ trans('staff::local.education') }}</h4>
                              
                              <div class="col-lg-6 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.institution') }}</label>                                 
                                <input type="text" class="form-control" disabled value="{{old('institution',$employee->institution)}}"
                                  placeholder="{{ trans('staff::local.institution') }}">
                                </div>
                              </div>
                              <div class="col-lg-6 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.qualification') }}</label>                                 
                                <input type="text" class="form-control" disabled value="{{old('qualification',$employee->qualification)}}"
                                  placeholder="{{ trans('staff::local.qualification') }}">
                                </div>
                              </div>
                            </div>  
                            {{-- salary --}}
                            <div class="tab-pane" id="tabVerticalLeft18" aria-labelledby="baseVerticalLeft1-tab8">
                              <h4 class="purple">{{ trans('staff::local.salary') }}</h4>
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.salary_mode') }}</label>
                                      <select name="salary_mode" class="form-control" disabled>                                        
                                        <option {{old('salary_mode',$employee->salary_mode) =='Cash' ||
                                        old('salary_mode',$employee->salary_mode) == trans('staff::local.cash') ? 'selected':'' }} value="Cash">{{ trans('staff::local.cash') }}</option>                                            
                                        <option {{old('salary_mode',$employee->salary_mode) =='Bank' ||
                                        old('salary_mode',$employee->salary_mode) == trans('staff::local.bank') ? 'selected':'' }} value="Bank">{{ trans('staff::local.bank') }}</option>                                            
                                      </select>                                          
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.salary_bank_name') }}</label>
                                      <input type="text" class="form-control " disabled value="{{old('salary_bank_name',$employee->salary_bank_name)}}"
                                        placeholder="{{ trans('staff::local.salary_bank_name') }}"                                           
                                        name="salary_bank_name">                                            
                                    </div>
                                </div>
                              </div> 
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                  <div class="form-group">
                                    <label>{{ trans('staff::local.bank_account') }}</label>
                                    <input type="number" min="0" class="form-control " disabled value="{{old('bank_account',$employee->bank_account)}}"
                                      placeholder="{{ trans('staff::local.bank_account') }}"                                           
                                      name="bank_account">                                            
                                  </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.salary_suspend') }}</label>
                                      <select name="salary_suspend" class="form-control" disabled>                                        
                                        <option {{old('salary_suspend',$employee->salary_suspend) =='No' ||
                                        old('salary_suspend',$employee->salary_suspend) == trans('staff::local.no') ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                                
                                        <option {{old('salary_suspend',$employee->salary_suspend) =='Yes' ||
                                        old('salary_suspend',$employee->salary_suspend) == trans('staff::local.yes') ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                      </select>                                          
                                    </div>
                                </div>
                             
                              </div> 
                            </div>
                            {{-- skills --}}
                            <div class="tab-pane" id="tabVerticalLeft19" aria-labelledby="baseVerticalLeft1-tab9">
                              <h4 class="purple">{{ trans('staff::local.skills') }}</h4>
                              <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                  <label>{{ trans('staff::local.skills') }}</label>
                                  <ul style="list-style: none" id="skill_id">
                    
                                  </ul>
                                </div>
                              </div>
                            </div>  
                            {{-- _documents --}}
                            <div class="tab-pane" id="tabVerticalLeft20" aria-labelledby="baseVerticalLeft1-tab10">
                              <h4 class="purple">{{ trans('staff::local.required_documents') }}</h4>
                              <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                  <label>{{ trans('staff::local.required_documents') }}</label>
                                  <ul style="list-style: none" id="document_id">
                                      
                                  </ul>
                                </div>
                              </div>
                            </div>  
                            {{-- social & medical_insurance --}}
                            <div class="tab-pane" id="tabVerticalLeft21" aria-labelledby="baseVerticalLeft1-tab11">
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.social_insurance') }}</label>
                                      <select name="social_insurance" class="form-control" disabled>
                                        
                                        <option {{old('social_insurance',$employee->social_insurance) =='Yes'||
                                        old('social_insurance',$employee->social_insurance) == trans('staff::local.yes') ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                        <option {{old('social_insurance',$employee->social_insurance) =='No' ||
                                        old('social_insurance',$employee->social_insurance) == trans('staff::local.no')? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                                      </select>                                       
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.social_insurance_num') }}</label>
                                      <input type="number" min="0" class="form-control " disabled value="{{old('social_insurance_num',$employee->social_insurance_num)}}" 
                                      placeholder="{{ trans('staff::local.social_insurance_num') }}"
                                        name="social_insurance_num">                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.social_insurance_date') }}</label>
                                      <input type="date" class="form-control" disabled value="{{old('social_insurance_date',$employee->social_insurance_date)}}"                                       
                                        name="social_insurance_date">                                        
                                    </div>
                                </div>                        
                              </div> 
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.medical_insurance') }}</label>
                                      <select name="medical_insurance" class="form-control" disabled>
                                        
                                        <option {{old('medical_insurance',$employee->medical_insurance) =='Yes' ||
                                        old('medical_insurance',$employee->medical_insurance) == trans('staff::local.yes') ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                        <option {{old('medical_insurance',$employee->medical_insurance) =='No' ||
                                        old('medical_insurance',$employee->medical_insurance) == trans('staff::local.no') ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                                      </select>                                       
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.medical_insurance_num') }}</label>
                                      <input type="number" min="0" class="form-control " disabled value="{{old('medical_insurance_num',$employee->medical_insurance_num)}}" 
                                      placeholder="{{ trans('staff::local.medical_insurance_num') }}"
                                        name="medical_insurance_num">                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.medical_insurance_date') }}</label>
                                      <input type="date" class="form-control" disabled value="{{old('medical_insurance_date',$employee->medical_insurance_date)}}"                                       
                                        name="medical_insurance_date">                                        
                                    </div>
                                </div>                        
                              </div> 
                            </div>  
                            {{-- leave_work --}}
                            <div class="tab-pane" id="tabVerticalLeft22" aria-labelledby="baseVerticalLeft1-tab12">
                              <h4 class="purple">{{ trans('staff::local.leave_work') }}</h4>
                              <div class="row" style="margin-left: 0;">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.leave_date') }}</label>
                                      <input type="date" class="form-control " disabled value="{{old('leave_date',$employee->leave_date)}}"                                           
                                        name="leave_date">                                            
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.leaved') }}</label>
                                      <select name="leaved" class="form-control" disabled>                    
                                        <option {{old('leaved',$employee->leaved) =='No' ||
                                        old('leaved',$employee->leaved) == trans('staff::local.no') ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                                
                                        <option {{old('leaved',$employee->leaved) =='Yes' ||
                                        old('leaved',$employee->leaved) == trans('staff::local.yes') ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                      </select>                                          
                                    </div>
                                </div>
                              </div> 
                              <div class="col-lg-6 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.exit_interview_feedback') }}</label>                                 
                                     <textarea disabled name="feestaff::local.exit_interview_feedback" class="form-control" disable cols="30" rows="5">{{old('exit_interview_feedback',$employee->exit_interview_feedback)}}</textarea>                                         
                                </div>
                              </div>
                              <div class="col-lg-6 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.leave_reason') }}</label>                                 
                                     <textarea disabled name="feestaff::local.leave_reason" class="form-control" disable cols="30" rows="5">{{old('leave_reason',$employee->leave_reason)}}</textarea>                                         
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
    </div>      
</div>

@include('staff::employees.includes.profile._dudction')
@include('staff::deductions.includes._reason')
@include('staff::employees.includes.profile._loans')
@include('staff::employees.includes.profile._vacations')
@include('staff::employees.includes.profile._permission')
@include('staff::employees.includes.profile._payrolls')
@endsection

@section('script')
    <script>
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

          (function getHolidays()
          {
            var employee_id = "{{$employee->id}}";
            
              $.ajax({
                type:'POST',
                url:'{{route("getHolidaysSelected")}}',
                data: {
                    _method       : 'PUT',
                    employee_id   : employee_id,
                    _token        : '{{ csrf_token() }}'
                  },
                dataType:'json',
                success:function(data){
                  $('#holiday_id').html(data);
                }
              });
          }());  

          (function getDocumets()
          {
            var employee_id = "{{$employee->id}}";
            
              $.ajax({
                type:'POST',
                url:'{{route("getDocumentsSelected")}}',
                data: {
                    _method       : 'PUT',
                    employee_id   : employee_id,
                    _token        : '{{ csrf_token() }}'
                  },
                dataType:'json',
                success:function(data){
                  $('#document_id').html(data);
                }
              });
          }());  

          (function getSkills()
          {
            var employee_id = "{{$employee->id}}";
            
              $.ajax({
                type:'POST',
                url:'{{route("getSkillsSelected")}}',
                data: {
                    _method       : 'PUT',
                    employee_id   : employee_id,
                    _token        : '{{ csrf_token() }}'
                  },
                dataType:'json',
                success:function(data){
                  $('#skill_id').html(data);
                }
              });
          }()); 

          function deduction(employee_id)
          {
            event.preventDefault();  
            $('#dynamic-table').DataTable().destroy();            
            
            var myTable = $('#dynamic-table').DataTable({
              "info":     true,              
              "bLengthChange" : false,          
              "pageLength": 5, // set page records
              ajax:{
                  type:'POST',
                  url:'{{route("deductions.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'amount',              name: 'amount'},               
                    {data: 'date_deduction',      name: 'date_deduction'},                             
                    {data: 'approval1',           name: 'approval1'},                                           
                    {data: 'approval2',           name: 'approval2'},                                                               
                    {data: 'updated_at',          name: 'updated_at'},  
                    {data: 'reason',              name: 'reason'},                     
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')                      
            $('#deduction').modal({backdrop: 'static', keyboard: false})
            $('#deduction').modal('show');
          }   
          
          function reason(reason)
          {
              event.preventDefault();          
              $('#reason_text').val(reason);			
              $('#reason').modal({backdrop: 'static', keyboard: false})
              $('#reason').modal('show');
          }    

          function loans(employee_id)
          {
            event.preventDefault();  
            $('#dynamic-table-loan').DataTable().destroy();            
            
            var myTable = $('#dynamic-table-loan').DataTable({
              "info":     true,              
              "bLengthChange" : false,          
              "pageLength": 5, // set page records
              ajax:{
                  type:'POST',
                  url:'{{route("loans.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'amount',              name: 'amount'},               
                    {data: 'date_loan',           name: 'date_loan'},                             
                    {data: 'approval1',           name: 'approval1'},                                           
                    {data: 'approval2',           name: 'approval2'},                                                               
                    {data: 'updated_at',          name: 'updated_at'},                      
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')                      
            $('#loan').modal({backdrop: 'static', keyboard: false})
            $('#loan').modal('show');            
          }                               

          function vacations(employee_id)
          {
            event.preventDefault();  
            $('#dynamic-table-vacation').DataTable().destroy();            
            
            var myTable = $('#dynamic-table-vacation').DataTable({
              "info":     true,              
              "bLengthChange" : false,          
              "pageLength": 5, // set page records
              ajax:{
                  type:'POST',
                  url:'{{route("vacations.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'vacation_type',       name: 'vacation_type'},                             
                    {data: 'date_vacation',       name: 'date_vacation'},                             
                    {data: 'vacation_period',     name: 'vacation_period'},              
                    {data: 'count',               name: 'count'},                               
                    {data: 'approval1',           name: 'approval1'},                                           
                    {data: 'approval2',           name: 'approval2'},                                           
                    {data: 'attachments',         name: 'attachments'},                                                                                  
                    {data: 'updated_at',          name: 'updated_at'},                      
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')                      
            $('#vacation').modal({backdrop: 'static', keyboard: false})
            $('#vacation').modal('show');            
          }  

          function permissions(employee_id)
          {
            event.preventDefault();  
            $('#dynamic-table-permission').DataTable().destroy();            
            
            var myTable = $('#dynamic-table-permission').DataTable({
              "info":     true,              
              "bLengthChange" : false,          
              "pageLength": 5, // set page records
              ajax:{
                  type:'POST',
                  url:'{{route("leave-permissions.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'date_leave',          name: 'date_leave'},                             
                    {data: 'time_leave',          name: 'time_leave'}, 
                    {data: 'leave_permission_id', name: 'leave_permission_id'},                                                                         
                    {data: 'approval1',           name: 'approval1'},                                           
                    {data: 'approval2',           name: 'approval2'},                                           
                    {data: 'updated_at',          name: 'updated_at'},                     
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')                      
            $('#permission').modal({backdrop: 'static', keyboard: false})
            $('#permission').modal('show');            
          }   

          function payrolls(employee_id)
          {
            event.preventDefault();  
            $('#dynamic-table-payroll').DataTable().destroy();            
            
            var myTable = $('#dynamic-table-payroll').DataTable({
              "info":     true,              
              "bLengthChange" : false,          
              "pageLength": 5, // set page records
              ajax:{
                  type:'POST',
                  url:'{{route("payroll-process.profile")}}',
                  data: {
                      _method       : 'PUT',
                      employee_id   : employee_id,                                      
                      _token        : '{{ csrf_token() }}'
                  }
                },
                // columns
                columns: [                    
                    {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},                             
                    {data: 'payrollSheet',        name: 'payrollSheet'},
                    {data: 'period',              name: 'period'},              
                    {data: 'from_date',           name: 'from_date'},               
                    {data: 'to_date',             name: 'to_date'},                
                    {data: 'value',               name: 'value'},                
                ],
                @include('layouts.backEnd.includes.datatables._datatableLang')
            });
            @include('layouts.backEnd.includes.datatables._multiSelect')                      
            $('#payroll').modal({backdrop: 'static', keyboard: false})
            $('#payroll').modal('show'); 
          }                                      
    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
