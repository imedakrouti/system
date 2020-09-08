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
                                <label class="col-md-3 label-control">{{ trans('student::local.id_type') }}</label>
                                <div class="col-md-9">                    
                                    <select id="student_id_type" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="national_id">{{ trans('student::local.national_id') }}</option>
                                        <option value="passport">{{ trans('student::local.passport') }}</option>                                
                                    </select>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.gender') }}</label>
                                <div class="col-md-9">                    
                                    <select id="gender" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="male">{{ trans('student::local.male') }}</option>
                                        <option value="female">{{ trans('student::local.female') }}</option>                                
                                    </select>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.student_type') }}</label>
                                <div class="col-md-9">                    
                                    <select id="student_type" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="applicant">{{ trans('student::local.applicant') }}</option>
                                        <option value="student">{{ trans('student::local.student') }}</option>                                                                        
                                    </select>                            
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.reg_type') }}</label>
                                <div class="col-md-9">                    
                                    <select id="reg_type" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="return">{{ trans('student::local.return') }}</option>
                                        <option value="arrival">{{ trans('student::local.arrival') }}</option>                                
                                        <option value="noob">{{ trans('student::local.noob') }}</option>                                
                                        <option value="transfer">{{ trans('student::local.transfer') }}</option>                                
                                    </select>                            
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.register_status_id') }}</label>
                                <div class="col-md-9">
                                    <select id="registration_status_id" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        @foreach ($regStatus as $status)
                                            <option value="{{$status->id}}">
                                                {{session('lang') == trans('admin.ar') ?$status->ar_name_status:$status->en_name_status}}
                                            </option>
                                        @endforeach
                                    </select>                            
                                </div>
                            </div>    
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.educational_mandate') }}</label>
                                <div class="col-md-9">                    
                                    <select id="educational_mandate" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="father">{{ trans('student::local.father') }}</option>
                                        <option value="mother">{{ trans('student::local.mother') }}</option>                                                                                                                  
                                    </select>                                    
                                </div>
                              </div>                                                                                
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.division_id') }}</label>
                                <div class="col-md-9">
                                    <select id="division_id" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{$division->id}}">
                                                {{session('lang') == trans('admin.ar') ?$division->ar_division_name:$division->en_division_name}}
                                            </option>
                                        @endforeach
                                    </select>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.grade_id') }}</label>
                                <div class="col-md-9">
                                    <select id="grade_id" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{$grade->id}}">
                                                {{session('lang') == trans('admin.ar') ?$grade->ar_grade_name:$grade->en_grade_name}}
                                            </option>
                                        @endforeach
                                    </select>                            
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.term') }}</label>
                                <div class="col-md-9">                    
                                    <select id="term" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="all">{{ trans('student::local.all_term') }}</option>
                                        <option value="first">{{ trans('student::local.first_term') }}</option>                                
                                        <option value="second">{{ trans('student::local.second_term') }}</option>                                
                                    </select>                            
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.school_id') }}</label>
                                <div class="col-md-9">
                                    <select id="school_id" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        @foreach ($schools as $school)
                                            <option {{old('school_id') == $school->id ?'selected' : ''}} value="{{$school->id}}">
                                                {{$school->school_name}}
                                            </option>
                                        @endforeach
                                    </select>                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.second_lang_id') }}</label>
                                <div class="col-md-9">
                                    <select id="second_lang_id" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        @foreach ($studyLangs as $lang)
                                            <option value="{{$lang->id}}">
                                                {{session('lang') == trans('admin.ar') ?$lang->ar_name_lang:$lang->en_name_lang}}
                                            </option>
                                        @endforeach
                                    </select>                            
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-md-3 label-control">{{ trans('student::local.recognition') }}</label>
                                <div class="col-md-9">                    
                                    <select id="recognition" class="form-control">
                                        <option value="">{{ trans('student::local.select') }}</option>
                                        <option value="facebook">{{ trans('student::local.fb') }}</option>
                                        <option value="parent">{{ trans('student::local.parent') }}</option>                                
                                        <option value="street">{{ trans('student::local.street') }}</option>                                
                                        <option value="school_hub">{{ trans('student::local.school_hub') }}</option>
                                    </select>
                                </div>
                              </div>                                                                                  
                        </div>  
                    </div>
                  </div>
                             
              </div>
            </div>
            <div class="modal-footer dark">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">{{ trans('student::local.close') }}</button>              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>