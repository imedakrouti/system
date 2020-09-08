<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
      href="#tab1" aria-expanded="true">{{ trans('student::local.father_data') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2"
      aria-expanded="false">{{ trans('student::local.mother_data') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3"
      aria-expanded="false">{{ trans('student::local.extra_info') }}</a>
    </li>
</ul>
<div class="tab-content px-1 pt-1">
    <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
        <h4 class="form-section"> {{ trans('student::local.father_main_data') }}</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.ar_st_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('ar_st_name')}}" placeholder="{{ trans('student::local.ar_st_name') }}"
                      name="ar_st_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.ar_nd_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('ar_nd_name')}}" placeholder="{{ trans('student::local.ar_nd_name') }}"
                      name="ar_nd_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.ar_rd_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('ar_rd_name')}}" placeholder="{{ trans('student::local.ar_rd_name') }}"
                      name="ar_rd_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.ar_th_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('ar_th_name')}}" placeholder="{{ trans('student::local.ar_th_name') }}"
                      name="ar_th_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
        </div>      
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.en_st_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('en_st_name')}}" placeholder="{{ trans('student::local.en_st_name') }}"
                      name="en_st_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.en_nd_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('en_nd_name')}}" placeholder="{{ trans('student::local.en_nd_name') }}"
                      name="en_nd_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.en_rd_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('en_rd_name')}}" placeholder="{{ trans('student::local.en_rd_name') }}"
                      name="en_rd_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.en_th_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('en_th_name')}}" placeholder="{{ trans('student::local.en_th_name') }}"
                      name="en_th_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.id_type') }}</label>
                  <div class="col-md-9">                   
                      <select name="id_type" class="form-control"  required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          <option {{old('id_type') == 'national_id' ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                          <option {{old('id_type') == 'passport' ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.id_number') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('id_number')}}" placeholder="{{ trans('student::local.id_number') }}"
                      name="id_number" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.religion') }}</label>
                  <div class="col-md-9">                    
                      <select name="religion" class="form-control" required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          <option {{old('religion') == 'muslim' ?'selected':''}} value="muslim">{{ trans('student::local.muslim') }}</option>
                          <option {{old('religion') == 'non_muslim' ?'selected':''}} value="non_muslim">{{ trans('student::local.non_muslim') }}</option>                                
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.nationality_id') }}</label>
                  <div class="col-md-9">
                      <select name="nationality_id" class="form-control " required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          @foreach ($nationalities as $nationality)
                              <option {{old('nationality_id') == $nationality->id ?'selected' : ''}} value="{{$nationality->id}}">{{$nationality->ar_name_nat_male}}</option>
                          @endforeach
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.job') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('job')}}" placeholder="{{ trans('student::local.job') }}"
                    name="job" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.qualification') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('qualification')}}" placeholder="{{ trans('student::local.qualification') }}"
                    name="qualification" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.facebook') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('facebook')}}" placeholder="{{ trans('student::local.facebook') }}"
                    name="facebook">
                </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.whatsapp_number') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('whatsapp_number')}}" placeholder="{{ trans('student::local.whatsapp_number') }}"
                    name="whatsapp_number">
                </div>
              </div>
          </div>
        </div>     
        <h4 class="form-section"> {{ trans('student::local.contacts_data') }}</h4> 
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.home_phone') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('home_phone')}}" placeholder="{{ trans('student::local.home_phone') }}"
                      name="home_phone">
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.mobile1') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('mobile1')}}" placeholder="{{ trans('student::local.mobile1') }}"
                      name="mobile1" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.mobile2') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('mobile2')}}" placeholder="{{ trans('student::local.mobile2') }}"
                      name="mobile2">
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.email') }}</label>
                  <div class="col-md-9">
                    <input type="email" class="form-control " value="{{old('email')}}" placeholder="{{ trans('student::local.email') }}"
                      name="email">
                  </div>
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.block_no') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('block_no')}}" placeholder="{{ trans('student::local.block_no') }}"
                      name="block_no" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.street_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('street_name')}}" placeholder="{{ trans('student::local.street_name') }}"
                      name="street_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.state') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('state')}}" placeholder="{{ trans('student::local.state') }}"
                      name="state" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.government') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('government')}}" placeholder="{{ trans('student::local.government') }}"
                      name="government" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
        </div>    
    </div>
    <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
        <h4 class="form-section"> {{ trans('student::local.mother_main_data') }}</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-md-2 label-control">{{ trans('student::local.mother_full_name') }}</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control " value="{{old('full_name')}}" placeholder="{{ trans('student::local.mother_full_name') }}"
                      name="full_name" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>                              
        </div>         
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.id_type') }}</label>
                  <div class="col-md-9">                    
                      <select name="id_type_m" class="form-control" required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          <option {{old('id_type_m') == 'national_id' ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                          <option {{old('id_type_m') == 'passport' ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.id_number') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('id_number_m')}}" placeholder="{{ trans('student::local.id_number') }}"
                      name="id_number_m" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.religion') }}</label>
                  <div class="col-md-9">                    
                      <select name="religion_m" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('religion_m') == 'muslim' ?'selected':''}} value="muslim">{{ trans('student::local.muslim_m') }}</option>
                        <option {{old('religion_m') == 'non_muslim' ?'selected':''}} value="non_muslim">{{ trans('student::local.non_muslim_m') }}</option>                                
                    </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.nationality_id') }}</label>
                  <div class="col-md-9">
                      <select name="nationality_id_m" class="form-control " required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          @foreach ($nationalities as $nationality)
                              <option {{old('nationality_id_m') == $nationality->id ?'selected' : ''}} value="{{$nationality->id}}">{{$nationality->ar_name_nat_female}}</option>
                          @endforeach
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
        </div>   
        <div class="row">
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.job') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('job_m')}}" placeholder="{{ trans('student::local.job') }}"
                    name="job_m" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.qualification') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('qualification_m')}}" placeholder="{{ trans('student::local.qualification') }}"
                    name="qualification_m" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.facebook') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('facebook_m')}}" placeholder="{{ trans('student::local.facebook') }}"
                    name="facebook_m">
                </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.whatsapp_number') }}</label>
                <div class="col-md-9">
                  <input type="text" class="form-control " value="{{old('whatsapp_number')}}" placeholder="{{ trans('student::local.whatsapp_number') }}"
                    name="whatsapp_number_m">
                </div>
              </div>
          </div>
        </div>  
        <h4 class="form-section"> {{ trans('student::local.contacts_data') }}</h4> 
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.home_phone') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('home_phone_m')}}" placeholder="{{ trans('student::local.home_phone') }}"
                      name="home_phone_m">
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.mobile1') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('mobile1_m')}}" placeholder="{{ trans('student::local.mobile1') }}"
                      name="mobile1_m" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.mobile2') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('mobile2_m')}}" placeholder="{{ trans('student::local.mobile2') }}"
                      name="mobile2_m">
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.email') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('email_m')}}" placeholder="{{ trans('student::local.email') }}"
                      name="email_m">
                  </div>
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.block_no') }}</label>
                  <div class="col-md-9">
                    <input type="number" min="0" class="form-control " value="{{old('block_no_m')}}" placeholder="{{ trans('student::local.block_no') }}"
                      name="block_no_m" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.street_name') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('street_name_m')}}" placeholder="{{ trans('student::local.street_name') }}"
                      name="street_name_m" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.state') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('state_m')}}" placeholder="{{ trans('student::local.state') }}"
                      name="state_m" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.government') }}</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('government_m')}}" placeholder="{{ trans('student::local.government') }}"
                      name="government_m" required>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
        </div>          
    </div>
    <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
        <h4 class="form-section"> {{ trans('student::local.extra_info') }}</h4> 
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.educational_mandate') }}</label>
                  <div class="col-md-9">                    
                      <select name="educational_mandate" class="form-control" required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          <option {{old('educational_mandate') == 'father' ?'selected':''}} value="father">{{ trans('student::local.father') }}</option>
                          <option {{old('educational_mandate') == 'mother' ?'selected':''}} value="mother">{{ trans('student::local.mother') }}</option>                                                                                                                  
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.marital_status') }}</label>
                  <div class="col-md-9">                    
                      <select name="marital_status" class="form-control" required>
                          <option value="">{{ trans('student::local.select') }}</option>
                          <option {{old('marital_status') == 'married' ?'selected':''}} value="married">{{ trans('student::local.married') }}</option>
                          <option {{old('marital_status') == 'divorced' ?'selected':''}} value="divorced">{{ trans('student::local.divorced') }}</option>                                
                          <option {{old('marital_status') == 'separated' ?'selected':''}} value="separated">{{ trans('student::local.separated') }}</option>                                
                          <option {{old('marital_status') == 'widower' ?'selected':''}} value="widower">{{ trans('student::local.widower') }}</option>
                      </select>
                      <span class="red">{{ trans('student::local.requried') }}</span>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                  <label class="col-md-3 label-control">{{ trans('student::local.recognition') }}</label>
                  <div class="col-md-9">                    
                      <select name="recognition" class="form-control">
                          <option value="">{{ trans('student::local.select') }}</option>
                          <option {{old('recognition') == 'facebook' ?'selected':''}} value="facebook">{{ trans('student::local.fb') }}</option>
                          <option {{old('recognition') == 'parent' ?'selected':''}} value="parent">{{ trans('student::local.parent') }}</option>                                
                          <option {{old('recognition') == 'street' ?'selected':''}} value="street">{{ trans('student::local.street') }}</option>                                
                          <option {{old('recognition') == 'school_hub' ?'selected':''}} value="school_hub">{{ trans('student::local.school_hub') }}</option>
                      </select>
                  </div>
                </div>
            </div>            
        </div>  
    </div>
</div>  