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
                  <input type="number" min="0" class="form-control " value="{{old('attendance_id')}}"                             
                      name="attendance_id" required>   
                  <span class="red">{{ trans('staff::local.required') }}</span>                                                     
                  </div>
              </div>
              <div class="col-lg-3 col-md-3">
                  <div class="form-group">
                  <label>{{ trans('staff::local.domain_role') }}</label>
                  <select name="domain_role" class="form-control">
                    <option value="null">{{ trans('staff::local.select') }}</option>
                    <option value="super admin">{{ trans('staff::local.super_admin') }}</option>
                    <option value="manager">{{ trans('staff::local.manager') }}</option>
                    <option value="super visor">{{ trans('staff::local.super_visor') }}</option>
                    <option value="staff">{{ trans('staff::local.staff') }}</option>
                    <option value="teacher">{{ trans('staff::local.teacher') }}</option>                    
                  </select>
                  </div>
              </div>
           </div>

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.ar_st_name') }}</label>
                      <input type="text" class="form-control " value="{{old('ar_st_name')}}" 
                      placeholder="{{ trans('staff::local.ar_st_name') }}"
                        name="ar_st_name" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.ar_nd_name') }}</label>
                      <input type="text" class="form-control " value="{{old('ar_nd_name')}}" 
                      placeholder="{{ trans('staff::local.ar_nd_name') }}"
                        name="ar_nd_name" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.ar_rd_name') }}</label>
                      <input type="text" class="form-control " value="{{old('ar_rd_name')}}" 
                      placeholder="{{ trans('staff::local.ar_rd_name') }}"
                        name="ar_rd_name">                                            
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.ar_th_name') }}</label>
                      <input type="text" class="form-control " value="{{old('ar_th_name')}}" 
                      placeholder="{{ trans('staff::local.ar_th_name') }}"
                        name="ar_th_name">                                            
                    </div>
                </div>
            </div> 

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.en_st_name') }}</label>
                      <input type="text" class="form-control " value="{{old('en_st_name')}}" 
                      placeholder="{{ trans('staff::local.en_st_name') }}"
                        name="en_st_name" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.en_nd_name') }}</label>
                      <input type="text" class="form-control " value="{{old('en_nd_name')}}" 
                      placeholder="{{ trans('staff::local.en_nd_name') }}"
                        name="en_nd_name" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.en_rd_name') }}</label>
                      <input type="text" class="form-control " value="{{old('en_rd_name')}}" 
                      placeholder="{{ trans('staff::local.en_rd_name') }}"
                        name="en_rd_name">                                            
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.en_th_name') }}</label>
                      <input type="text" class="form-control " value="{{old('en_th_name')}}" 
                      placeholder="{{ trans('staff::local.en_th_name') }}"
                        name="en_th_name">                                            
                    </div>
                </div>
            </div>   

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.national_id') }}</label>
                      <input type="text" class="form-control " value="{{old('national_id')}}" 
                      placeholder="{{ trans('staff::local.national_id') }}"
                        name="national_id" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.email') }}</label>
                      <input type="text" class="form-control " value="{{old('email')}}" 
                      placeholder="{{ trans('staff::local.email') }}"
                        name="email">                                            
                    </div>
                </div>
            </div>  

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.mobile1') }}</label>
                      <input type="number" class="form-control " value="{{old('mobile1')}}" 
                      placeholder="{{ trans('staff::local.mobile1') }}"
                        name="mobile1">                                            
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.mobile2') }}</label>
                      <input type="number" class="form-control " value="{{old('mobile2')}}" 
                      placeholder="{{ trans('staff::local.mobile2') }}"
                        name="mobile2">                                            
                    </div>
                </div>
            </div> 

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-2 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.salary') }}</label>
                      <input type="number" min="0" class="form-control " value="{{old('salary')}}" 
                      placeholder="{{ trans('staff::local.salary') }}"
                        name="salary" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.bus_value') }}</label>
                      <input type="number" min="0" class="form-control " value="{{old('bus_value')}}" 
                      placeholder="{{ trans('staff::local.bus_value') }}"
                        name="bus_value">                                            
                    </div>
                </div>      
                <div class="col-lg-2 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.leave_balance') }}</label>
                      <input type="number" min="0" class="form-control " value="{{old('leave_balance')}}" required
                      placeholder="{{ trans('staff::local.leave_balance') }}"
                        name="leave_balance">   
                        <span class="red">{{ trans('staff::local.required') }}</span>                                                                   
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.vacation_allocated') }}</label>
                      <input type="number" min="0" class="form-control " disabled value="{{old('vacation_allocated')}}" 
                      placeholder="{{ trans('staff::local.vacation_allocated') }}"
                        name="vacation_allocated">                                            
                    </div>
                </div>
            </div>
            <div class="row" style="margin-left: 0;">
              <div class="col-lg-2 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.insurance_value') }}</label>
                    <input type="number" min="0" class="form-control " value="{{old('insurance_value')}}" 
                    placeholder="{{ trans('staff::local.insurance_value') }}"
                      name="insurance_value">                      
                  </div>
              </div>
              <div class="col-lg-2 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.tax_value') }}</label>
                    <input type="number" min="0" class="form-control " value="{{old('tax_value')}}" 
                    placeholder="{{ trans('staff::local.tax_value') }}"
                      name="tax_value">                                            
                  </div>
              </div>      
          </div>    
            <div class="row" style="margin-left: 0;">
              <div class="col-lg-4 col-md-4">
                  <div class="form-group">
                    <label >{{ trans('staff::local.employee_image') }}</label>
                    <input  type="file" name="employee_image" class="form-control"/>                
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
                      <input type="date" class="form-control " value="{{old('dob', date('Y-m-d'))}}"                                           
                        name="dob">                                            
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.gender') }}</label>
                      <select name="gender" class="form-control">                        
                        <option {{old('gender') =='male' ? 'selected':'' }} value="male">{{ trans('staff::local.male') }}</option>    
                        <option {{old('gender') =='female' ? 'selected':'' }} value="female">{{ trans('staff::local.female') }}</option>    
                      </select>                                          
                    </div>
                </div>
            </div> 

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.religion') }}</label>
                      <select name="religion" class="form-control">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                        <option {{old('religion') =='muslim' ? 'selected':'' }} value="muslim">{{ trans('staff::local.muslim') }}</option>    
                        <option {{old('religion') =='christian' ? 'selected':'' }} value="christian">{{ trans('staff::local.christian') }}</option>    
                      </select>                                           
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.native') }}</label>
                      <select name="native" class="form-control">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                        <option {{old('native') =='Arabic' ? 'selected':'' }} value="Arabic">{{ trans('staff::local.arabic') }}</option>    
                        <option {{old('native') =='English' ? 'selected':'' }} value="English">{{ trans('staff::local.english') }}</option>        
                        <option {{old('native') =='French' ? 'selected':'' }} value="French">{{ trans('staff::local.french') }}</option>        
                        <option {{old('native') =='German' ? 'selected':'' }} value="German">{{ trans('staff::local.german') }}</option>        
                        <option {{old('native') =='Italy' ? 'selected':'' }} value="Italy">{{ trans('staff::local.italy') }}</option>        
                      </select>                                          
                    </div>
                </div>
            </div> 

            <div class="row" style="margin-left: 0;">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.marital_status') }}</label>
                      <select name="marital_status" class="form-control">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                        <option {{old('marital_status') =='Single' ? 'selected':'' }} value="Single">{{ trans('staff::local.single') }}</option>    
                        <option {{old('marital_status') =='Married' ? 'selected':'' }} value="Married">{{ trans('staff::local.married') }}</option>        
                        <option {{old('marital_status') =='Separated' ? 'selected':'' }} value="Separated">{{ trans('staff::local.separated') }}</option>        
                        <option {{old('marital_status') =='Divorced' ? 'selected':'' }} value="Divorced">{{ trans('staff::local.divorced') }}</option>        
                        <option {{old('marital_status') =='Widowed' ? 'selected':'' }} value="Widowed">{{ trans('staff::local.widowed') }}</option>           
                      </select>                                           
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.military_service') }}</label>
                      <select name="military_service" class="form-control">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                        <option {{old('military_service') =='Exempted' ? 'selected':'' }} value="Exempted">{{ trans('staff::local.exempted') }}</option>        
                        <option {{old('military_service') =='Finished' ? 'selected':'' }} value="Finished">{{ trans('staff::local.finished') }}</option>               
                      </select>                                          
                    </div>
                </div>
            </div> 

            <div class="col-lg-6 col-md-12">
                <div class="form-group row">
                    <label>{{ trans('staff::local.address') }}</label>                                 
                    <textarea name="address" class="form-control" cols="30" rows="5">{{old('address')}}</textarea>                                         
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="form-group row">
                    <label>{{ trans('staff::local.health_details') }}</label>                                 
                    <textarea name="health_details" class="form-control" cols="30" rows="5">{{old('health_details')}}</textarea>                                         
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
                    <input type="date" class="form-control " value="{{old('hiring_date', date('Y-m-d'))}}" id="hiring_date"                                           
                      name="hiring_date">                                            
                  </div>
              </div>
              <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.direct_manager_id') }}</label>
                      <select name="direct_manager_id" " class="form-control select2">
                          <option value="">{{ trans('staff::local.select') }}</option>
                          @foreach ($employees as $employee)
                              <option {{old('direct_manager_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                              @if (session('lang') == 'ar')
                              [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                              @else
                              [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$staff->en_th_name}}
                              @endif
                              </option>
                          @endforeach
                      </select> <br>                                          
                    </div>
                </div>
            </div> 

            <div class="row" style="margin-left: 0;">
              <div class="col-lg-3 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.sector_id') }}</label>
                    <select id="sector_id" name="sector_id" class="form-control select2">
                      <option value="">{{ trans('staff::local.select') }}</option>    
                      @foreach ($sectors as $sector)
                          <option value="{{$sector->id}}">
                          {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}</option>
                      @endforeach
                    </select>                                             
                  </div>
              </div>
              <div class="col-lg-3 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.department_id') }}</label>
                    <select id="department_id" name="department_id" disabled class="form-control select2">
                      <option value="">{{ trans('staff::local.select') }}</option>    
                          
                    </select>                                          
                  </div>
              </div>
            </div>
            <div class="row" style="margin-left: 0;">
              <div class="col-lg-3 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.section_id') }}</label>
                    <select name="section_id" class="form-control select2">
                      <option value="">{{ trans('staff::local.select') }}</option>    
                        @foreach ($sections as $section)
                            <option value="{{$section->id}}">
                            {{session('lang') == 'ar' ? $section->ar_section:$section->en_section}}</option>
                        @endforeach
                    </select>                                             
                  </div>
              </div>
              <div class="col-lg-3 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.position_id') }}</label>
                    <select name="position_id" class="form-control select2">
                      <option value="">{{ trans('staff::local.select') }}</option>    
                        @foreach ($positions as $position)
                            <option value="{{$position->id}}">
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
              <select name="timetable_id" class="form-control">
                <option value="">{{ trans('staff::local.select') }}</option>    
                  @foreach ($timetables as $timetable)
                      <option value="{{$timetable->id}}">
                      {{session('lang') == 'ar' ? $timetable->ar_timetable:$timetable->en_timetable}}</option>
                  @endforeach
              </select> 
            </div>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="form-group row">
              <label>{{ trans('staff::local.holiday_id') }}</label>
              <ul style="list-style: none">
                  @foreach ($holidays as $holiday)
                      <h5>
                          <li>
                              <label class="pos-rel">
                                  <input type="checkbox" class="ace" name="holiday_id[]" value="{{$holiday->id}}">
                          <span class="lbl"></span> {{session('lang') == 'ar'?$holiday->ar_holiday:
                          $holiday->en_holiday}}
                              </label>                                                            
                          </li>
                      </h5>
                  @endforeach
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
                  <select name="has_contract" class="form-control">
                    <option value="">{{ trans('staff::local.select') }}</option>    
                    <option {{old('has_contract') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                    <option {{old('has_contract') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                  </select>                                             
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.contract_type') }}</label>
                  <select name="contract_type" class="form-control">
                    <option value="">{{ trans('staff::local.select') }}</option>    
                    <option {{old('contract_type') =='Full Time' ? 'selected':'' }} value="Full Time">{{ trans('staff::local.full_Time') }}</option>                                            
                    <option {{old('contract_type') =='Part Time' ? 'selected':'' }} value="Part Time">{{ trans('staff::local.part_Time') }}</option>                                                
                  </select>                                          
                </div>
            </div>
          </div> 
          <div class="row" style="margin-left: 0;">
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.contract_date') }}</label>
                  <input type="date" class="form-control " value="{{old('contract_date', date('Y-m-d'))}}"                                           
                    name="contract_date">                                            
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.contract_end_date') }}</label>
                  <input type="date" class="form-control " value="{{old('contract_end_date')}}"                                           
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
                <textarea name="previous_experience" class="form-control" cols="30" rows="5">{{old('previous_experience')}}</textarea>                                         
            </div>
          </div>
        </div>      
        {{-- education --}}
        <div class="tab-pane" id="tabVerticalLeft17" aria-labelledby="baseVerticalLeft1-tab7">
          <h4 class="purple">{{ trans('staff::local.education') }}</h4>
          
          <div class="col-lg-6 col-md-12">
            <div class="form-group row">
                <label>{{ trans('staff::local.institution') }}</label>                                 
            <input type="text" class="form-control" value="{{old('institution')}}"
              placeholder="{{ trans('staff::local.institution') }}">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group row">
                <label>{{ trans('staff::local.qualification') }}</label>                                 
            <input type="text" class="form-control" value="{{old('qualification')}}"
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
                  <select name="salary_mode" class="form-control">                                        
                    <option {{old('salary_mode') =='Cash' ? 'selected':'' }} value="Cash">{{ trans('staff::local.cash') }}</option>                                            
                    <option {{old('salary_mode') =='Bank' ? 'selected':'' }} value="Bank">{{ trans('staff::local.bank') }}</option>                                            
                  </select>                                          
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.salary_bank_name') }}</label>
                  <input type="text" class="form-control " value="{{old('salary_bank_name')}}"
                    placeholder="{{ trans('staff::local.salary_bank_name') }}"                                           
                    name="salary_bank_name">                                            
                </div>
            </div>
          </div> 
          <div class="row" style="margin-left: 0;">
            <div class="col-lg-3 col-md-6">
              <div class="form-group">
                <label>{{ trans('staff::local.bank_account') }}</label>
                <input type="number" min="0" class="form-control " value="{{old('bank_account')}}"
                  placeholder="{{ trans('staff::local.bank_account') }}"                                           
                  name="bank_account">                                            
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.salary_suspend') }}</label>
                  <select name="salary_suspend" class="form-control">                                        
                    <option {{old('salary_suspend') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                                
                    <option {{old('salary_suspend') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                  </select>                                          
                </div>
            </div>
         
          </div> 
          <div class="row" style="margin-left: 0;">
              <div class="col-lg-3 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.payroll_sheet_name') }}</label> <br>
                    <select name="payroll_sheet_id" class="form-control">
                        <option value="">{{ trans('staff::local.select') }}</option>
                        @foreach ($payrollSheets as $payrollSheet)
                            <option {{old('payroll_sheet_id') == $payrollSheet->id ? 'selected' :''}} value="{{$payrollSheet->id}}">
                                  {{session('lang') == 'ar' ? $payrollSheet->ar_sheet_name : $payrollSheet->en_sheet_name}}                                  
                            </option>
                        @endforeach
                    </select> <br>                
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
              <ul style="list-style: none">
                  @foreach ($skills as $skill)
                      <h5>
                          <li>
                              <label class="pos-rel">
                                  <input type="checkbox" class="ace" name="skill_id[]" value="{{$skill->id}}">
                          <span class="lbl"></span> {{session('lang') == 'ar'?$skill->ar_skill:
                          $skill->ar_skill}}
                              </label>                                                            
                          </li>
                      </h5>
                  @endforeach
              </ul>
            </div>
          </div>
        </div>  
        {{-- required_documents --}}
        <div class="tab-pane" id="tabVerticalLeft20" aria-labelledby="baseVerticalLeft1-tab10">
          <h4 class="purple">{{ trans('staff::local.required_documents') }}</h4>
          <div class="col-lg-3 col-md-12">
            <div class="form-group row">
              <label>{{ trans('staff::local.required_documents') }}</label>
              <ul style="list-style: none">
                  @foreach ($documents as $document)
                      <h5>
                          <li>
                              <label class="pos-rel">
                                  <input type="checkbox" class="ace" name="document_id[]" value="{{$document->id}}">
                          <span class="lbl"></span> {{session('lang') == 'ar'?$document->ar_document:
                          $document->ar_document}}
                              </label>                                                            
                          </li>
                      </h5>
                  @endforeach
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
                  <select name="social_insurance" class="form-control">
                    <option value="">{{ trans('staff::local.select') }}</option>    
                    <option {{old('social_insurance') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                    <option {{old('social_insurance') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                  </select>                                       
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.social_insurance_num') }}</label>
                  <input type="number" min="0" class="form-control " value="{{old('social_insurance_num')}}" 
                  placeholder="{{ trans('staff::local.social_insurance_num') }}"
                    name="social_insurance_num">                                        
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.social_insurance_date') }}</label>
                  <input type="date" class="form-control" value="{{old('social_insurance_date', date('Y-m-d'))}}"                                       
                    name="social_insurance_date">                                        
                </div>
            </div>                        
          </div> 
          <div class="row" style="margin-left: 0;">
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.medical_insurance') }}</label>
                  <select name="medical_insurance" class="form-control">
                    <option value="">{{ trans('staff::local.select') }}</option>    
                    <option {{old('medical_insurance') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                    <option {{old('medical_insurance') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                  </select>                                       
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.medical_insurance_num') }}</label>
                  <input type="number" min="0" class="form-control " value="{{old('medical_insurance_num')}}" 
                  placeholder="{{ trans('staff::local.medical_insurance_num') }}"
                    name="medical_insurance_num">                                        
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.medical_insurance_date') }}</label>
                  <input type="date" class="form-control" value="{{old('medical_insurance_date', date('Y-m-d'))}}"                                       
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
                  <input type="date" class="form-control " value="{{old('leave_date')}}"                                           
                    name="leave_date">                                            
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                  <label>{{ trans('staff::local.leaved') }}</label>
                  <select name="leaved" class="form-control">                    
                    <option {{old('leaved') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                                
                    <option {{old('leaved') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                  </select>                                          
                </div>
            </div>
          </div> 
          <div class="col-lg-6 col-md-12">
            <div class="form-group row">
                <label>{{ trans('staff::local.exit_interview_feedback') }}</label>                                 
                <textarea name="feestaff::local.exit_interview_feedback" class="form-control" cols="30" rows="5">{{old('feestaff::local.exit_interview_feedback')}}</textarea>                                         
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group row">
                <label>{{ trans('staff::local.leave_reason') }}</label>                                 
                <textarea name="feestaff::local.leave_reason" class="form-control" cols="30" rows="5">{{old('feestaff::local.leave_reason')}}</textarea>                                         
            </div>
          </div>
        </div>                                                  
    </div>
</div>  