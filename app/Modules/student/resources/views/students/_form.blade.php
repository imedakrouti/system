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
        <a class="nav-link" id="link-tab1" data-toggle="tab" href="#active6" aria-controls="link1"
        aria-expanded="false">{{ trans('student::local.medical') }}</a>
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
            <input type="hidden" name="father_id" value="{{$father->id}}">
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.ar_student_name') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('ar_student_name')}}" placeholder="{{ trans('student::local.ar_student_name') }}"
                    name="ar_student_name" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.en_student_name') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('en_student_name')}}" placeholder="{{ trans('student::local.en_student_name') }}"
                    name="en_student_name" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.mother_name') }}</label>
                <div class="col-md-9">
                    <select name="mother_id" class="form-control " required>                
                        @foreach ($mothers as $mother)
                            <option {{old('mother_id') == $mother->id ?'selected' : ''}} value="{{$mother->id}}">{{$mother->full_name}}</option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.id_type') }}</label>
                <div class="col-md-9">                    
                    <select name="id_type" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('id_type') == 'national_id' ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                        <option {{old('id_type') == 'passport' ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.id_number') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('id_number')}}" placeholder="{{ trans('student::local.id_number') }}"
                    name="id_number" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-3 label-control">{{ trans('student::local.native_lang_id') }}</label>
                    <div class="col-md-9">
                        <select name="native_lang_id" class="form-control " required>
                            <option value="">{{ trans('student::local.select') }}</option>
                            @foreach ($speakingLangs as $lang)
                                <option {{old('native_lang_id') == $lang->id ?'selected' : ''}} value="{{$lang->id}}">
                                    {{session('lang') == trans('admin.ar') ?$lang->ar_name_lang:$lang->en_name_lang}}
                                </option>
                            @endforeach
                        </select>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-3 label-control">{{ trans('student::local.second_lang_id') }}</label>
                    <div class="col-md-9">
                        <select name="second_lang_id" class="form-control " required>
                            <option value="">{{ trans('student::local.select') }}</option>
                            @foreach ($studyLangs as $lang)
                                <option {{old('second_lang_id') == $lang->id ?'selected' : ''}} value="{{$lang->id}}">
                                    {{session('lang') == trans('admin.ar') ?$lang->ar_name_lang:$lang->en_name_lang}}
                                </option>
                            @endforeach
                        </select>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.dob') }}</label>
                <div class="col-md-9">
                    <input type="date" class="form-control " value="{{old('dob')}}" placeholder="{{ trans('student::local.dob') }}"
                    name="dob" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.place_birth') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('place_birth')}}" placeholder="{{ trans('student::local.place_birth') }}"
                    name="place_birth">                    
                </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.gender') }}</label>
                <div class="col-md-9">                    
                    <select name="gender" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('gender') == 'male' ?'selected':''}} value="male">{{ trans('student::local.male') }}</option>
                        <option {{old('gender') == 'female' ?'selected':''}} value="female">{{ trans('student::local.female') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                  <label class="col-md-3 label-control" >{{ trans('student::local.son_employee') }}</label>
                  <div class="col-md-9">                    
                    <select name="son_employee" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                  <label class="col-md-3 label-control" >{{ trans('student::local.guardian_id') }}</label>
                  <div class="col-md-9">                    
                    <select name="guardian_id" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($guardians as $guardian)
                            <option {{old('guardian_id') == $guardian->id ?'selected' : ''}} value="{{$guardian->id}}">
                                {{$guardian->guardian_full_name}}
                            </option>
                        @endforeach
                    </select>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.return_country') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control " value="{{old('return_country')}}" placeholder="{{ trans('student::local.return_country') }}"
                    name="return_country">                    
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                  <label class="col-md-3 label-control" >{{ trans('student::local.student_image') }}</label>
                  <div class="col-md-9">                    
                    <input  type="file" name="student_image"/>
                  </div>
                </div>
              </div>
        </div>        
    </div>
    <div class="tab-pane" id="active2" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="false">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-3 label-control">{{ trans('student::local.student_type') }}</label>
                    <div class="col-md-9">                    
                        <select name="student_type" class="form-control" required>
                            <option value="">{{ trans('student::local.select') }}</option>
                            <option {{old('student_type') == 'applicant' ?'selected':''}} value="applicant">{{ trans('student::local.applicant') }}</option>
                            <option {{old('student_type') == 'student' ?'selected':''}} value="student">{{ trans('student::local.student') }}</option>                                                                        
                        </select>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                    </div>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-3 label-control">{{ trans('student::local.reg_type') }}</label>
                    <div class="col-md-9">                    
                        <select name="reg_type" class="form-control" required>
                            <option value="">{{ trans('student::local.select') }}</option>
                            <option {{old('reg_type') == 'return' ?'selected':''}} value="return">{{ trans('student::local.return') }}</option>
                            <option {{old('reg_type') == 'arrival' ?'selected':''}} value="arrival">{{ trans('student::local.arrival') }}</option>                                
                            <option {{old('reg_type') == 'noob' ?'selected':''}} value="noob">{{ trans('student::local.noob') }}</option>                                
                            <option {{old('reg_type') == 'transfer' ?'selected':''}} value="transfer">{{ trans('student::local.transfer') }}</option>                                
                        </select>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.register_status_id') }}</label>
                <div class="col-md-9">
                    <select name="registration_status_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($regStatus as $status)
                            <option {{old('registration_status_id') == $status->id ?'selected' : ''}} value="{{$status->id}}">
                                {{session('lang') == trans('admin.ar') ?$status->ar_name_status:$status->en_name_status}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
        </div>            
    
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.division_id') }}</label>
                <div class="col-md-9">
                    <select name="division_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($divisions as $division)
                            <option {{old('division_id') == $division->id ?'selected' : ''}} value="{{$division->id}}">
                                {{session('lang') == trans('admin.ar') ?$division->ar_division_name:$division->en_division_name}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.grade_id') }}</label>
                <div class="col-md-9">
                    <select name="grade_id" class="form-control " required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($grades as $grade)
                            <option {{old('grade_id') == $grade->id ?'selected' : ''}} value="{{$grade->id}}">
                                {{session('lang') == trans('admin.ar') ?$grade->ar_grade_name:$grade->en_grade_name}}
                            </option>
                        @endforeach
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.term') }}</label>
                <div class="col-md-9">                    
                    <select name="term" class="form-control" required>
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('term') == 'all' ?'selected':''}} value="all">{{ trans('student::local.all_term') }}</option>
                        <option {{old('term') == 'first' ?'selected':''}} value="first">{{ trans('student::local.first_term') }}</option>                                
                        <option {{old('term') == 'second' ?'selected':''}} value="second">{{ trans('student::local.second_term') }}</option>                                
                    </select>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="active3" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">
        <ul style="list-style: none">
            @foreach ($documents as $document)
                <li>
                    <h6><input type="checkbox" name="admision_document_id[]" value="{{$document->id}}">
                        {{session('lang') == trans('admin.ar')?$document->ar_document_name:$document->ar_document_name}}
                    </h6>
                </li>
            @endforeach   
        </ul>      
    </div> 
    <div class="tab-pane" id="active4" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.application_date') }}</label>
                <div class="col-md-9">
                    <input type="date" class="form-control " value="{{old('application_date')}}" placeholder="{{ trans('student::local.application_date') }}"
                    name="application_date" required>
                    <span class="red">{{ trans('student::local.requried') }}</span>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul style="list-style: none">
                    @foreach ($steps as $step)
                        <li>
                            <h6>
                                <input type="checkbox" name="admission_step_id[]" value="{{$step->id}}">
                                {{session('lang') == trans('admin.ar')?$step->ar_step:$step->ar_step}}
                            </h6>
                        </li>
                    @endforeach   
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
            <div class="col-md-6">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.school_id') }}</label>
                <div class="col-md-9">
                    <select name="school_id" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                        @foreach ($schools as $school)
                            <option {{old('school_id') == $school->id ?'selected' : ''}} value="{{$school->id}}">
                                {{$school->school_name}}
                            </option>
                        @endforeach
                    </select>                    
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.transfer_reason') }}</label>
                <div class="col-md-9">                                    
                    <textarea name="transfer_reason" class="form-control" cols="30" rows="5">{{old('transfer_reason')}}</textarea>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="active6" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">        
        <div class="row">
            <div class="col-md-3">
                <div class="form-group row">
                <label class="col-md-3 label-control">{{ trans('student::local.blood_type') }}</label>
                <div class="col-md-9">                    
                    <select name="blood_type" class="form-control">
                        <option value="">{{ trans('student::local.select') }}</option>
                        <option {{old('blood_type') == 'unknown' ?'selected':''}} value="unknown">{{ trans('student::local.unknown') }}</option>
                        <option {{old('blood_type') == '-O' ?'selected':''}} value="-O">-O</option>                                
                        <option {{old('blood_type') == '+O' ?'selected':''}} value="+O">+O</option>                                
                        <option {{old('blood_type') == '-A' ?'selected':''}} value="-A">-A</option>                                
                        <option {{old('blood_type') == '+A' ?'selected':''}} value="+A">+A</option>                                
                        <option {{old('blood_type') == '-B' ?'selected':''}} value="-B">-B</option>                                
                        <option {{old('blood_type') == '+B' ?'selected':''}} value="+B">+B</option>                                
                        <option {{old('blood_type') == '-AB' ?'selected':''}} value="-AB">-AB</option>                                
                        <option {{old('blood_type') == '+AB' ?'selected':''}} value="+AB">+AB</option>                                
                    </select>                    
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h6><input class="mb-1" type="checkbox" value="yes" name="food_sensitivity"> {{ trans('student::local.food_sensitivity') }}</h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="medicine_sensitivity"> {{ trans('student::local.medicine_sensitivity') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="other_sensitivity"> {{ trans('student::local.other_sensitivity') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="have_medicine"> {{ trans('student::local.have_medicine') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="vision_problem"> {{ trans('student::local.vision_problem') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="use_glasses"> {{ trans('student::local.use_glasses') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="hearing_problems"> {{ trans('student::local.hearing_problems') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="speaking_problems"> {{ trans('student::local.speaking_problems') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="chest_pain"> {{ trans('student::local.chest_pain') }}
            </div>
            <div class="col-md-6">
                <h6><input class="mb-1" type="checkbox" value="yes" name="breath_problem"> {{ trans('student::local.breath_problem') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="asthma"> {{ trans('student::local.asthma') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="have_asthma_medicine"> {{ trans('student::local.have_asthma_medicine') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="heart_problem"> {{ trans('student::local.heart_problem') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="hypertension"> {{ trans('student::local.hypertension') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="diabetic"> {{ trans('student::local.diabetic') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="anemia"> {{ trans('student::local.anemia') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="cracking_blood"> {{ trans('student::local.cracking_blood') }} </h6>
                <h6><input class="mb-1" type="checkbox" value="yes" name="coagulation"> {{ trans('student::local.coagulation') }} </h6>
            </div>
        </div>
    </div>    
    <div class="tab-pane" id="active7" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">
        <div class="col-md-6">
            <div class="form-group row">
            <label class="col-md-3 label-control">{{ trans('student::local.submitted_name') }}</label>
            <div class="col-md-9">
                <input type="text" class="form-control " value="{{old('submitted_name')}}" placeholder="{{ trans('student::local.submitted_name') }}"
                name="submitted_name">                
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
            <label class="col-md-3 label-control">{{ trans('student::local.submitted_id_number') }}</label>
            <div class="col-md-9">
                <input type="number" min="0" class="form-control " value="{{old('submitted_id_number')}}" placeholder="{{ trans('student::local.submitted_id_number') }}"
                name="submitted_id_number">                
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
            <label class="col-md-3 label-control">{{ trans('student::local.submitted_mobile') }}</label>
            <div class="col-md-9">
                <input type="number" min="0" class="form-control " value="{{old('submitted_mobile')}}" placeholder="{{ trans('student::local.submitted_mobile') }}"
                name="submitted_mobile">                
            </div>
            </div>
        </div>
    </div> 
    <div class="tab-pane" id="active8" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
        aria-expanded="false">        
        <div class="form-group col-12 mb-2 contact-repeater">
            <div data-repeater-list="repeater-group">
              <div class="input-group mb-1" data-repeater-item>
                <input type="text" name="full_address[]" placeholder="{{ trans('student::local.full_address') }}" class="form-control" id="example-tel-input">
                <span class="input-group-append" id="button-addon2">
                  <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                </span>
              </div>
            </div>
            <button type="button" data-repeater-create class="btn btn-primary">
              <i class="ft-plus"></i> {{ trans('student::local.add_address') }}
            </button>
          </div>
    </div>         
  </div>