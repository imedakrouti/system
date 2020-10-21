<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">

      <!-- Modal -->
      <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="	myModalLabel16"
      aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header dark">
              <h4 class="modal-title" id="myModalLabel16"> {{ trans('student::local.field_search') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body dark">
              <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.sector_id') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select id="sector_id" name="sector_id" class="form-control select2">
                                        <option value="">{{ trans('staff::local.select') }}</option>    
                                        @foreach ($sectors as $sector)
                                            <option value="{{$sector->id}}">
                                            {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}</option>
                                        @endforeach
                                    </select>                              
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.department_id') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select id="department_id" disabled name="department_id" class="form-control select2">
                                        <option value="">{{ trans('staff::local.select') }}</option>    
                                    </select>                              
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.section_id') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select id="section_id" name="section_id" class="form-control select2">
                                        <option value="">{{ trans('staff::local.select') }}</option>    
                                        @foreach ($sections as $section)
                                            <option value="{{$section->id}}">
                                            {{session('lang') == 'ar' ? $section->ar_section:$section->en_section}}</option>
                                        @endforeach
                                    </select>                              
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.position_id') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select id="position_id" name="position_id" class="form-control select2">
                                        <option value="">{{ trans('staff::local.select') }}</option>    
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">
                                            {{session('lang') == 'ar' ? $position->ar_position:$position->en_position}}</option>
                                        @endforeach
                                    </select>                              
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.timetable_id') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select id="timetable_id" name="timetable_id" class="form-control select2">
                                        <option value="">{{ trans('staff::local.select') }}</option>    
                                        @foreach ($timetables as $timetable)
                                            <option value="{{$timetable->id}}">
                                            {{session('lang') == 'ar' ? $timetable->ar_timetable:$timetable->en_timetable}}</option>
                                        @endforeach
                                    </select>                              
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.leaved') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select id="leaved" name="leaved" class="form-control">
                                        <option value="">{{ trans('staff::local.all') }}</option>                                          
                                        <option value="No">{{ trans('staff::local.no') }}</option>                                          
                                        <option value="Yes">{{ trans('staff::local.yes') }}</option>                                          
                                    </select>                              
                                </div>
                            </div>
  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.has_contract') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select name="has_contract" id="has_contract" class="form-control">                                        
                                        <option value="">{{ trans('staff::local.all') }}</option>                                           
                                        <option {{old('has_contract') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                        <option {{old('has_contract') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                                      </select>                               
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.contract_type') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select name="contract_type" class="form-control">                                        
                                        <option value="">{{ trans('staff::local.all') }}</option>                                          
                                        <option {{old('contract_type') =='Full Time' ? 'selected':'' }} value="Full Time">{{ trans('staff::local.full_Time') }}</option>                                            
                                        <option {{old('contract_type') =='Part Time' ? 'selected':'' }} value="Part Time">{{ trans('staff::local.part_Time') }}</option>                                                
                                      </select>                               
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.salary_mode') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select name="salary_mode" id="salary_mode" class="form-control">   
                                        <option value="">{{ trans('staff::local.all') }}</option>                                                                               
                                        <option {{old('salary_mode') =='Cash' ? 'selected':'' }} value="Cash">{{ trans('staff::local.cash') }}</option>                                            
                                        <option {{old('salary_mode') =='Bank' ? 'selected':'' }} value="Bank">{{ trans('staff::local.bank') }}</option>                                            
                                      </select>                                
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.salary_suspend') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select name="salary_suspend" id="salary_suspend" class="form-control"> 
                                        <option value="">{{ trans('staff::local.all') }}</option>                                                                                 
                                        <option {{old('salary_suspend') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                                
                                        <option {{old('salary_suspend') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                      </select>                                
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.social_insurance') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select name="social_insurance" id="social_insurance" class="form-control">
                                        <option value="">{{ trans('staff::local.all') }}</option>                                           
                                        <option {{old('social_insurance') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                        <option {{old('social_insurance') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                                      </select>                                
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-12 label-control">{{ trans('staff::local.medical_insurance') }}</label>
                                <div class="col-lg-8 col-md-12">                    
                                    <select name="medical_insurance" id="medical_insurance" class="form-control">                                        
                                        <option value="">{{ trans('staff::local.all') }}</option>                                             
                                        <option {{old('medical_insurance') =='Yes' ? 'selected':'' }} value="Yes">{{ trans('staff::local.yes') }}</option>                                            
                                        <option {{old('medical_insurance') =='No' ? 'selected':'' }} value="No">{{ trans('staff::local.no') }}</option>                                            
                                      </select>                                
                                </div>
                            </div>                                                                   
                        </div>  
                    </div>
                  </div>
                             
              </div>
            </div>
            <div class="modal-footer dark">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">{{ trans('student::local.close_model') }}</button>              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>