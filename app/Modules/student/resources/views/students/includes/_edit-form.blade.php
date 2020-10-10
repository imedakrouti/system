<ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
    <li class="nav-item">
        <a class="nav-link active" id="active-tab1" data-toggle="tab" href="#active1" aria-controls="active1"
        aria-expanded="true">{{ trans('student::local.applicant_student_data') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="link-tab1" data-toggle="tab" href="#active2" aria-controls="link1"
        aria-expanded="false">{{ trans('student::local.stage_data') }}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="linkOpt-tab1" data-toggle="tab" href="#active4" aria-controls="linkOpt1">
        {{ trans('student::local.admission_steps') }}</a>
    </li>    
    <li class="nav-item">
        <a class="nav-link" id="linkOpt-tab1" data-toggle="tab" href="#active3" aria-controls="linkOpt1">
        {{ trans('student::local.student_documents') }}</a>
    </li>     
    <li class="nav-item">
        <a class="nav-link" id="link-tab1" data-toggle="tab" href="#active5" aria-controls="link1"
        aria-expanded="false">{{ trans('student::local.last_school_data') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="linkOpt-tab1" data-toggle="tab" href="#active7" aria-controls="linkOpt1">
        {{ trans('student::local.submitted_data') }}</a>
    </li>  
    <li class="nav-item">
        <a class="nav-link" id="linkOpt-tab1" data-toggle="tab" href="#active8" aria-controls="linkOpt1">
        {{ trans('student::local.more_address') }}</a>
    </li>       
</ul>
<div class="tab-content px-1 pt-1">
    <div role="tabpanel" class="tab-pane active" id="active1" aria-labelledby="active-tab1"
        aria-expanded="true">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.application_date') }}</label>
                    <input type="date" class="form-control " value="{{old('application_date',$student->application_date)}}" placeholder="{{ trans('student::local.application_date') }}"
                    name="application_date" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>              
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.ar_student_name') }}</label>
                    <input type="text" class="form-control " value="{{old('ar_student_name',$student->ar_student_name)}}" placeholder="{{ trans('student::local.ar_student_name') }}"
                    name="ar_student_name" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>              
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.en_student_name') }}</label>
                    <input type="text" class="form-control " value="{{old('en_student_name',$student->en_student_name)}}" placeholder="{{ trans('student::local.en_student_name') }}"
                    name="en_student_name" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>                
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.mother_name') }}</label>
                    <select name="mother_id" class="form-control " required>                
                        @foreach ($mothers as $mother)
                            <option {{old('mother_id',$student->mother_id) == $mother->id ?'selected' : ''}} value="{{$mother->id}}">{{$mother->full_name}}</option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>               
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.id_type') }}</label>
                    <select name="student_id_type" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('student_id_type',$student->student_id_type)  == 'national_id' ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                        <option {{old('student_id_type',$student->student_id_type)  == 'passport' ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>            
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.id_number') }}</label>
                    <input type="text" class="form-control " value="{{old('student_id_number',$student->student_id_number)}}" placeholder="{{ trans('student::local.id_number') }}"
                    name="student_id_number" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>              
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.nationality_id') }}</label>
                    <select name="nationality_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($nationalities as $nationality)
                            <option {{old('nationality_id',$student->nationality_id) == $nationality->id ?'selected' : ''}} value="{{$nationality->id}}">{{$nationality->ar_name_nat_male}}</option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>           
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.religion') }}</label>
                    <select name="religion" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('religion',$student->religion) == trans('student::local.muslim') || old('religion',$student->religion) == 'muslim' ||
                        old('religion',$student->religion) == trans('student::local.muslim_m') ?'selected':''}} value="muslim">{{ trans('student::local.muslim') }}</option>
                        <option {{old('religion',$student->religion) == trans('student::local.non_muslim') || old('religion',$student->religion) == 'non_muslim' ||
                        old('religion',$student->religion) == trans('student::local.non_muslim_m') ?'selected':''}} value="non_muslim">{{ trans('student::local.non_muslim') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>            
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.native_lang_id') }}</label>
                    <select name="native_lang_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($speakingLangs as $lang)
                            <option {{old('native_lang_id',$student->native_lang_id) == $lang->id ?'selected' : ''}} value="{{$lang->id}}">
                                {{session('lang') == 'ar' ?$lang->ar_name_lang:$lang->en_name_lang}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>                  
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.second_lang_id') }}</label>
                    <select name="second_lang_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($studyLangs as $lang)
                            <option {{old('second_lang_id',$student->second_lang_id) == $lang->id ?'selected' : ''}} value="{{$lang->id}}">
                                {{session('lang') == 'ar' ?$lang->ar_name_lang:$lang->en_name_lang}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>                  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.dob') }}</label>
                    <input type="date" class="form-control "  id="dob" value="{{old('dob',$student->dob)}}" placeholder="{{ trans('student::local.dob') }}"
                    name="dob" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                    <input type="text" class="age-display" value="0" id="dd" readonly>
                    <span>{{ trans('student::local.dd') }}</span>
                    <input type="text" class="age-display" value="0" id="mm" readonly>
                    <span>{{ trans('student::local.mm') }}</span>
                    <input type="text" class="age-display" value="0" id="yy" readonly>
                    <span>{{ trans('student::local.yy') }}</span>       
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.place_birth') }}</label>
                    <input type="text" class="form-control " value="{{old('place_birth',$student->place_birth)}}" placeholder="{{ trans('student::local.place_birth') }}"
                    name="place_birth">                                 
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.gender') }}</label>
                    <select name="gender" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('gender',$student->gender) == trans('student::local.male') ||
                        old('gender',$student->gender) == 'male' ?'selected':''}} value="male">{{ trans('student::local.male') }}</option>
                        <option {{old('gender',$student->gender) == trans('student::local.female') ||
                        old('gender',$student->gender) == 'female' ?'selected':''}} value="female">{{ trans('student::local.female') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label >{{ trans('student::local.son_employee') }}</label>
                    <select name="son_employee" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                    </select>                 
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label >{{ trans('student::local.guardian_id') }}</label>
                    <select name="guardian_id" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($guardians as $guardian)
                            <option {{old('guardian_id',$student->guardian_id) == $guardian->id ?'selected' : ''}} value="{{$guardian->id}}">
                                {{$guardian->guardian_full_name}}
                            </option>
                        @endforeach
                    </select>               
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.return_country') }}</label>
                    <input type="text" class="form-control " value="{{old('return_country',$student->return_country)}}" placeholder="{{ trans('student::local.return_country') }}"
                    name="return_country">                                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label >{{ trans('student::local.student_image') }}</label>
                    <input  type="file" name="student_image"/>            
                </div>
              </div>
        </div>        
    </div>
    <div class="tab-pane" id="active2" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="false">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.student_type') }}</label>
                    <select name="student_type" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('student_type',$student->student_type) == trans('student::local.applicant') ||
                        old('student_type',$student->student_type) == 'applicant'
                        ?'selected':''}} value="applicant">{{ trans('student::local.applicant') }}</option>
                        <option {{old('student_type',$student->student_type) == trans('student::local.student') ||
                        old('student_type',$student->student_type) == 'student'
                        ?'selected':''}} value="student">{{ trans('student::local.student') }}</option>                                                                        
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>               
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.reg_type') }}</label>
                    <select name="reg_type" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('reg_type',$student->reg_type) == trans('student::local.return') ||
                        old('reg_type',$student->reg_type) == 'return' ?'selected':''}} value="return">{{ trans('student::local.return') }}</option>
                        <option {{old('reg_type',$student->reg_type) == trans('student::local.arrival') ||
                        old('reg_type',$student->reg_type) == 'arrival' ?'selected':''}} value="arrival">{{ trans('student::local.arrival') }}</option>                                
                        <option {{old('reg_type',$student->reg_type) == trans('student::local.new') || 
                        old('reg_type',$student->reg_type) == 'new' ?'selected':''}} value="new">{{ trans('student::local.new') }}</option>                                
                        <option {{old('reg_type',$student->reg_type) == trans('student::local.transfer') ||
                        old('reg_type',$student->reg_type) == 'transfer' ?'selected':''}} value="transfer">{{ trans('student::local.transfer') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>                
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.register_status_id') }}</label>
                    <select name="registration_status_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($regStatus as $status)
                            <option {{old('registration_status_id',$student->registration_status_id) == $status->id ?'selected' : ''}} value="{{$status->id}}">
                                {{session('lang') == 'ar' ?$status->ar_name_status:$status->en_name_status}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>                
                </div>
            </div>
        </div>            
    
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.division_id') }}</label>
                    <select name="division_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($divisions as $division)
                            <option {{old('division_id',$student->division_id) == $division->id ?'selected' : ''}} value="{{$division->id}}">
                                {{session('lang') == 'ar' ?$division->ar_division_name:$division->en_division_name}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>            
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.grade_id') }}</label>
                    <select name="grade_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($grades as $grade)
                            <option {{old('grade_id',$student->grade_id) == $grade->id ?'selected' : ''}} value="{{$grade->id}}">
                                {{session('lang') == 'ar' ?$grade->ar_grade_name:$grade->en_grade_name}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>                
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                <label>{{ trans('student::local.term') }}</label>
                    <select name="term" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('term',$student->term) == 'all' ?'selected':''}} value="all">{{ trans('student::local.all_term') }}</option>
                        <option {{old('term',$student->term) == 'first' ?'selected':''}} value="first">{{ trans('student::local.first_term') }}</option>                                
                        <option {{old('term',$student->term) == 'second' ?'selected':''}} value="second">{{ trans('student::local.second_term') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>                
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="active3" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">              
        <ul style="list-style: none" id="documentId">
       
        </ul>      
    </div> 
    <div class="tab-pane" id="active4" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.emp_open_app') }}</label>
                    <select name="employee_id" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($admins as $admin)
                        <option  {{old('employee_id',$student->employee_id) == $admin->id ?'selected':''}} value="{{$admin->id}}">{{$admin->name}}</option>
                        @endforeach
                    </select>                  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul style="list-style: none" id="stepId">
                 
                </ul>
            </div>
        </div>
    </div>       
    <div class="tab-pane" id="active5" role="tabpanel" aria-labelledby="dropdownOpt1-tab1"
        aria-expanded="false">
      <div class="alert alert-light">
        <strong>{{ trans('student::local.last_school_info') }}</strong>
      </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('student::local.school_id') }}</label>
                    <select name="school_id" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($schools as $school)
                            <option {{old('school_id',$student->school_id) == $school->id ?'selected' : ''}} value="{{$school->id}}">
                                {{$school->school_name}}
                            </option>
                        @endforeach
                    </select>                                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.transfer_reason') }}</label>
                    <textarea name="transfer_reason" class="form-control" cols="30" rows="5">{{old('transfer_reason',$student->transfer_reason)}}</textarea>                
                </div>
            </div>
        </div>
    </div>    
    <div class="tab-pane" id="active7" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.submitted_name') }}</label>
                    <input type="text" class="form-control " value="{{old('submitted_name',$student->submitted_name)}}" placeholder="{{ trans('student::local.submitted_name') }}"
                    name="submitted_name">                            
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.submitted_id_number') }}</label>
                    <input type="number" min="0" class="form-control " value="{{old('submitted_id_number',$student->submitted_id_number)}}" placeholder="{{ trans('student::local.submitted_id_number') }}"
                    name="submitted_id_number">                            
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label>{{ trans('student::local.submitted_mobile') }}</label>
                    <input type="number" min="0" class="form-control " value="{{old('submitted_mobile',$student->submitted_mobile)}}" placeholder="{{ trans('student::local.submitted_mobile') }}"
                    name="submitted_mobile">                            
                </div>
            </div>            
        </div>        

    </div> 
    <div class="tab-pane" id="active8" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">   
        <div class="form-group col-12 mb-2 contact-repeater">
            <div data-repeater-list="repeater-group">
                @if (count($student->addresses) > 0)
                    @foreach ($student->addresses as $address)
                        <div class="input-group mb-1" data-repeater-item>
                            <input type="text" name="full_address[]" placeholder="{{ trans('student::local.full_address') }}" 
                            class="form-control" id="example-tel-input" value="{{$address->full_address}}">
                            <span class="input-group-append" id="button-addon2">
                            <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                            </span>
                        </div>
                    @endforeach  
                @else              
                    <div class="input-group mb-1" data-repeater-item>
                        <input type="text" name="full_address[]" placeholder="{{ trans('student::local.full_address') }}" 
                        class="form-control" id="example-tel-input" value="">
                        <span class="input-group-append" id="button-addon2">
                            <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                        </span>
                    </div>
                @endif
              <button type="button" data-repeater-create class="btn btn-primary mb-1">
                <i class="ft-plus"></i> {{ trans('student::local.add_address') }}
              </button>    
            </div>
          </div>       
    </div>         
</div>  