@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('students.index')}}">{{ trans('student::local.students') }}</a></li>
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
                    {{$student->ar_student_name}} <a href="{{route('father.show',$student->father_id)}}">{{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}</a>
                    @else
                    {{$student->en_student_name}} <a href="{{route('father.show',$student->father_id)}}">{{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}</a>
                    @endif                   
                    | <a href="{{route('mother.show',$student->mother_id)}}">{{$student->mother->full_name}}</a>  
                </h2> 
              </div>
              <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{route('student.create',$student->father_id)}}" class="mb-1 btn btn-success white"><i class="la la-plus"></i> {{ trans('student::local.add_sibling') }}</a>
                    <a href="{{route('students.edit',$student->id)}}" class="mb-1 btn btn-warning white"><i class="la la-edit"></i> {{ trans('student::local.edit') }}</a>
                    <a target="_blank" href="{{route('students.print',$student->id)}}" class="mb-1 btn btn-primary white"><i class="la la-print"></i> {{ trans('student::local.print') }}</a>
                    <a href="{{route('contacts.index',$student->father_id)}}" class="mb-1 btn btn-light white"><i class="la la-phone"></i> {{ trans('student::local.father_contacts') }}</a>                                        
                </div>
                @if ($student->student_type == trans('student::local.student'))                  
                    <div class="btn-group mr-1 mb-1">
                        <button type="button" class="btn btn-info btn-min-width dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> {{ trans('student::local.more') }}</button>
                        <div class="dropdown-menu">
                            <a href="{{route('commissioners.student',$student->id)}}" class="dropdown-item" >{{ trans('student::local.authorizations') }}</a>
                            <a href="{{route('daily-requests.student',$student->id)}}" class="dropdown-item" >{{ trans('student::local.permissions') }}</a>
                            <a href="{{route('parent-requests.student',$student->id)}}" class="dropdown-item" >{{ trans('student::local.parent_requests') }}</a>
                            <a href="{{route('student.report',$student->id)}}" class="dropdown-item" >{{ trans('student::local.student_reports') }}</a>
                            <a href="{{route('student-notes.index',$student->id)}}" class="dropdown-item" >{{ trans('student::local.notes') }}</a>
                            <a href="{{route('archives.student-files',$student->id)}}" class="dropdown-item" >{{ trans('student::local.archive') }}</a>
                            <a href="{{route('absences.student',$student->id)}}" class="dropdown-item" >{{ trans('student::local.absence') }}</a>
                            {{-- <a href="#" class="dropdown-item" >{{ trans('student::local.payments') }}</a>
                            <a href="#" class="dropdown-item" >{{ trans('student::local.books') }}</a>                      
                            <a href="#" class="dropdown-item" >{{ trans('student::local.uniform') }}</a>
                            <a href="#" class="dropdown-item" >{{ trans('student::local.buses') }}</a>
                            <a href="#" class="dropdown-item" >{{ trans('student::local.health_status') }}</a>                       --}}
                        </div>
                    </div>                                 
                @endif
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
                    @empty($student->student_image)
                    @php
                        $path_image = $student->gender == trans('student::local.male') ? 'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png'
                    @endphp
                    <img style="width : 100%" class="editable img-responsive student-image-profile" alt="Alex's Avatar" id="avatar2" 
                    src="{{asset($path_image)}}" />
                    @else
                    <img class="editable img-responsive student-image-profile" alt="Alex's Avatar" id="avatar2" 
                    src="{{asset('images/studentsImages/'.$student->student_image)}}" />
                    @endempty          
                </div>
                <div class="col-lg-12 col-md-6 mt-lg-1">
                    <h3 class="red center">
                        @if ($student->twins=='true' )
                            <a href="{{route('students.show',$student->id)}}">
                                <img width="50" class="editable img-responsive sibling-image" alt="Alex's Avatar" id="avatar2" 
                                src="{{asset('images/website/twins.png')}}" />
                            </a>
                        @endif  
                        <strong>{{$student->student_number}}</strong></h3>
                    <h3 class="purple center"><strong>{{$classroom}}</strong></h3>
                    <h6><strong>{{ trans('student::local.created_by') }} : {{$student->admin->name}}</strong></h6>
                    <h6><strong>{{ trans('student::local.created_at') }} : </strong></h6>{{$student->created_at}}
                    <h6><strong>{{ trans('student::local.updated_at') }} : </strong></h6>{{$student->updated_at}}
                    
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
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.application_date') }}</label>
                                        <input type="date" class="form-control " value="{{old('application_date',$student->application_date)}}" placeholder="{{ trans('student::local.application_date') }}"
                                        name="application_date"  disabled>                                                                                
                                    </div>
                                </div>
                            </div>                              
                            <div class="row">            
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.ar_student_name') }}</label>
                                        <input type="text" class="form-control " value="{{old('ar_student_name',$student->ar_student_name)}}" placeholder="{{ trans('student::local.ar_student_name') }}"
                                        name="ar_student_name" disabled>                                                                            
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.en_student_name') }}</label>
                                        <input type="text" class="form-control " value="{{old('en_student_name',$student->en_student_name)}}" placeholder="{{ trans('student::local.en_student_name') }}"
                                        name="en_student_name" disabled>                                                                            
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.mother_name') }}</label>
                                        <select name="mother_id" class="form-control " disabled>                
                                            @foreach ($mothers as $mother)
                                                <option {{old('mother_id',$student->mother_id) == $mother->id ?'selected' : ''}} value="{{$mother->id}}">{{$mother->full_name}}</option>
                                            @endforeach
                                        </select>                                                                            
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.id_type') }}</label>
                                        <select name="student_id_type" class="form-control" disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            <option {{old('student_id_type',$student->student_id_type)  == 'national_id' ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                                            <option {{old('student_id_type',$student->student_id_type)  == 'passport' ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.id_number') }}</label>
                                        <input type="text" class="form-control " value="{{old('student_id_number',$student->student_id_number)}}" placeholder="{{ trans('student::local.id_number') }}"
                                        name="student_id_number" disabled>                                                                            
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.nationality_id') }}</label>
                                        <select name="nationality_id" class="form-control " disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($nationalities as $nationality)
                                                <option {{old('nationality_id',$student->nationality_id) == $nationality->id ?'selected' : ''}} value="{{$nationality->id}}">{{$nationality->ar_name_nat_male}}</option>
                                            @endforeach
                                        </select>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.religion') }}</label>
                                        <select name="religion" class="form-control" disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            <option {{old('religion',$student->religion) == trans('student::local.muslim') || old('religion',$student->religion) == 'muslim' ||
                                            old('religion',$student->religion) == trans('student::local.muslim_m') ?'selected':''}} value="muslim">{{ trans('student::local.muslim') }}</option>
                                            <option {{old('religion',$student->religion) == trans('student::local.non_muslim') || old('religion',$student->religion) == 'non_muslim' ||
                                            old('religion',$student->religion) == trans('student::local.non_muslim_m') ?'selected':''}} value="non_muslim">{{ trans('student::local.non_muslim') }}</option>                                
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.native_lang_id') }}</label>
                                        <select name="native_lang_id" class="form-control "  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($speakingLangs as $lang)
                                                <option {{old('native_lang_id',$student->native_lang_id) == $lang->id ?'selected' : ''}} value="{{$lang->id}}">
                                                    {{session('lang') == 'ar' ?$lang->ar_name_lang:$lang->en_name_lang}}
                                                </option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.second_lang_id') }}</label>
                                        <select name="second_lang_id" class="form-control "  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($studyLangs as $lang)
                                                <option {{old('second_lang_id',$student->second_lang_id) == $lang->id ?'selected' : ''}} value="{{$lang->id}}">
                                                    {{session('lang') == 'ar' ?$lang->ar_name_lang:$lang->en_name_lang}}
                                                </option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.dob') }}</label>
                                        <input type="date" class="form-control" id="dob" value="{{old('dob',$student->dob)}}" placeholder="{{ trans('student::local.dob') }}"
                                        name="dob"  disabled>
                                        <input type="text" class="age-display" value="0" 
                                        id="{{ session('lang') == 'ar' ? 'dd' : 'yy' }}" disabled>
                                        <span>{{ session('lang') == 'ar' ? trans('student::local.dd') : trans('student::local.yy') }}</span>
                                        <input type="text" class="age-display" value="0" id="mm" disabled>
                                        <span>{{ trans('student::local.mm') }}</span>
                                        <input type="text" class="age-display" value="0" 
                                        id="{{ session('lang') == 'ar' ? 'yy' : 'dd' }}" disabled>
                                        <span>{{ session('lang') == 'ar' ? trans('student::local.yy') : trans('student::local.dd') }}</span>                                    
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.place_birth') }}</label>
                                        <input type="text" class="form-control " value="{{old('place_birth',$student->place_birth)}}" placeholder="{{ trans('student::local.place_birth') }}"
                                        name="place_birth" disabled>                                                        
                                    </div>
                                </div>
                    
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.gender') }}</label>
                                        <select name="gender" class="form-control" disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            <option {{old('gender',$student->gender) == trans('student::local.male') ||
                                            old('gender',$student->gender) == 'male' ?'selected':''}} value="male">{{ trans('student::local.male') }}</option>
                                            <option {{old('gender',$student->gender) == trans('student::local.female') ||
                                            old('gender',$student->gender) == 'female' ?'selected':''}} value="female">{{ trans('student::local.female') }}</option>                                
                                        </select>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label >{{ trans('student::local.son_employee') }}</label>
                                        <select name="son_employee" class="form-control" disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                        </select>                                      
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label >{{ trans('student::local.guardian_id') }}</label>
                                        <select name="guardian_id" class="form-control" disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($guardians as $guardian)
                                                <option {{old('guardian_id',$student->guardian_id) == $guardian->id ?'selected' : ''}} value="{{$guardian->id}}">
                                                    {{$guardian->guardian_full_name}}
                                                </option>
                                            @endforeach
                                        </select>                                      
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.return_country') }}</label>
                                        <input type="text" class="form-control " value="{{old('return_country',$student->return_country)}}" placeholder="{{ trans('student::local.return_country') }}"
                                        name="return_country" disabled>                                                        
                                    </div>
                                </div>
                            </div>        
                        </div>
                        <div class="tab-pane" id="active2" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.student_type') }}</label>
                                        <select name="student_type" class="form-control"  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            <option {{old('student_type',$student->student_type) == trans('student::local.applicant') ?'selected':''}} value="applicant">{{ trans('student::local.applicant') }}</option>
                                            <option {{old('student_type',$student->student_type) == trans('student::local.student') ?'selected':''}} value="student">{{ trans('student::local.student') }}</option>                                                                        
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.reg_type') }}</label>
                                        <select name="reg_type" class="form-control"  disabled>
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
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.register_status_id') }}</label>
                                        <select name="registration_status_id" class="form-control "  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($regStatus as $status)
                                                <option {{old('registration_status_id',$student->registration_status_id) == $status->id ?'selected' : ''}} value="{{$status->id}}">
                                                    {{session('lang') == 'ar' ?$status->ar_name_status:$status->en_name_status}}
                                                </option>
                                            @endforeach
                                        </select>                                    
                                    </div>
                                </div>
                            </div>            
                        
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.division_id') }}</label>
                                        <select name="division_id" class="form-control "  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($divisions as $division)
                                                <option {{old('division_id',$student->division_id) == $division->id ?'selected' : ''}} value="{{$division->id}}">
                                                    {{session('lang') == 'ar' ?$division->ar_division_name:$division->en_division_name}}
                                                </option>
                                            @endforeach
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.grade_id') }}</label>
                                        <select name="grade_id" class="form-control "  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($grades as $grade)
                                                <option {{old('grade_id',$student->grade_id) == $grade->id ?'selected' : ''}} value="{{$grade->id}}">
                                                    {{session('lang') == 'ar' ?$grade->ar_grade_name:$grade->en_grade_name}}
                                                </option>
                                            @endforeach
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.term') }}</label>
                                        <select name="term" class="form-control"  disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            <option {{old('term',$student->term) == 'all' ?'selected':''}} value="all">{{ trans('student::local.all_term') }}</option>
                                            <option {{old('term',$student->term) == 'first' ?'selected':''}} value="first">{{ trans('student::local.first_term') }}</option>                                
                                            <option {{old('term',$student->term) == 'second' ?'selected':''}} value="second">{{ trans('student::local.second_term') }}</option>                                
                                        </select>                                    
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
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.emp_open_app') }}</label>
                                        <select name="employee_id" class="form-control" disabled>
                                            <option value="">{{ trans('student::local.select') }}</option>
                                            @foreach ($admins as $admin)
                                            <option  {{old('employee_id',$student->employee_id) == $admin->id ?'selected':''}} value="{{$admin->id}}">{{$admin->name}}</option>
                                            @endforeach
                                        </select>                                      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <ul style="list-style: none" id="stepId" disabled>
                                     
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
                                        <select name="school_id" class="form-control" disabled>
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
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.transfer_reason') }}</label>
                                        <textarea name="transfer_reason" class="form-control" cols="30" disabled rows="5">{{old('transfer_reason',$student->transfer_reason)}}</textarea>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="active7" role="tabpanel" aria-labelledby="dropdownOpt2-tab1"
                            aria-expanded="false">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('student::local.submitted_name') }}</label>
                                    <input type="text" class="form-control " value="{{old('submitted_name',$student->submitted_name)}}" placeholder="{{ trans('student::local.submitted_name') }}"
                                    name="submitted_name" disabled>                                                
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('student::local.submitted_id_number') }}</label>
                                    <input type="number" min="0" class="form-control " value="{{old('submitted_id_number',$student->submitted_id_number)}}" placeholder="{{ trans('student::local.submitted_id_number') }}"
                                    name="submitted_id_number" disabled>                                                
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('student::local.submitted_mobile') }}</label>
                                    <input type="number" min="0" class="form-control " value="{{old('submitted_mobile',$student->submitted_mobile)}}" placeholder="{{ trans('student::local.submitted_mobile') }}"
                                    name="submitted_mobile" disabled>                                                
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
                                                <input type="text" name="full_address" placeholder="{{ trans('student::local.full_address') }}" 
                                                class="form-control" id="example-tel-input" value="{{$address->full_address}}" disabled>
                                            
                                            </div>
                                        @endforeach 
                                    @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                    <div class="alert alert-warning">
                                                        {{trans('student::local.no_addresses_added')}}
                                                   </div>
                                            </div>
                                        </div>
                                    @endif                                
                                        
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

<div class="row" > 
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="card" style="min-height: 200px">
        <div class="card-content collapse show">
          <div class="card-body">
            <div class="row mb-1">
                <div class="col-lg-6 col-md-12">
                    <h3 class="red">{{ trans('student::local.siblings') }}</h3>                    
                </div>
              </div>              
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>{{ trans('student::local.student_image') }}</th>
                      <th>{{ trans('student::local.student_number') }}</th>
                      <th>{{ trans('student::local.student_name') }}</th>
                      <th>{{ trans('student::local.student_type') }}</th>
                      <th>{{ trans('student::local.dob') }}</th>
                      <th>{{ trans('student::local.grade') }}</th>                      
                      <th>{{ trans('student::local.division') }}</th>                      
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($siblings as $sibling)
                        @if ( $sibling->id != $student->id)
                            <tr>
                                <td width="25">
                                    @empty($sibling->student_image)
                                        <a href="{{route('students.show',$sibling->id)}}">
                                            <img width="50" class="editable img-responsive sibling-image" alt="Alex's Avatar" id="avatar2" 
                                            src="{{asset('images/studentsImages/37.jpeg')}}" />
                                        </a>
                                    @else
                                        <a href="{{route('students.show',$sibling->id)}}">
                                            <img width="50" class="editable img-responsive sibling-image" alt="Alex's Avatar" id="avatar2" 
                                            src="{{asset('images/studentsImages/'.$sibling->student_image)}}" />
                                        </a>
                                    @endempty   
                                </td>
                                <td width="25">{{$sibling->student_number}}</td>
                                <td><a href="{{route('students.show',$sibling->id)}}">{{session('lang') == 'ar' ?$sibling->ar_student_name:$sibling->en_student_name}}</a></td>
                                <td>{{$sibling->student_type}}</td>
                                <td>{{$sibling->dob}}</td>
                                <td>{{session('lang') == 'ar' ?$sibling->grade->ar_grade_name:$sibling->grade->en_grade_name}}</td>
                                <td>{{session('lang') == 'ar' ?$sibling->division->ar_division_name:$sibling->division->en_division_name}}</td>
                                <td>
                                    @if ($sibling->twins=='true' )
                                        <a href="{{route('students.show',$sibling->id)}}">
                                            <img width="50" class="editable img-responsive sibling-image" alt="Alex's Avatar" id="avatar2" 
                                            src="{{asset('images/website/twins.png')}}" />
                                        </a>
                                    @endif                      
                                </td>
                            </tr>                            
                        @endif
                    @endforeach
                  </tbody>
                </table>  
              </div> 
          </div>
        </div>
      </div>
    </div>      
</div>

<div class="row" > 
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="card" style="min-height: 200px">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row mb-1">
                <div class="col-lg-6 col-md-12">
                    <h3 class="red">{{ trans('student::local.include_statement') }} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h3>                    
                </div>
                @if ($student->student_type == trans('student::local.student')) 
                    <div class="col-md-6">
                        <form action="{{route('statement.addStudent')}}" method="post">
                            @csrf
                            <input type="hidden" name="student_id" value="{{$student->id}}">
                            <input type="hidden" name="division_id" value="{{$student->division_id}}">
                            <input type="hidden" name="grade_id" value="{{$student->grade_id}}">                        
                            <input type="hidden" name="dob" value="{{$student->dob}}">
                            <input type="hidden" name="registration_status_id" value="{{$student->registration_status_id}}">
                            <button class="btn btn-dark pull-left"><i class="la la-file-text"></i> {{ trans('student::local.add_to_statement') }}</button>                    
                        </form>
                    </div>                                
                @endif
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>{{ trans('student::local.year') }}</th>
                      <th>{{ trans('student::local.grade') }}</th>
                      <th>{{ trans('student::local.division') }}</th>
                      <th>{{ trans('student::local.registration_status_id') }}</th>                      
                      <th>{{ trans('student::local.dd') }}</th>                      
                      <th>{{ trans('student::local.mm') }}</th>                      
                      <th>{{ trans('student::local.yy') }}</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($statements as $statement)
                        <tr>
                            <td>{{$statement->year->name}}</td>
                            <td>{{session('lang') == 'ar' ? $statement->grade->ar_grade_name : $statement->grade->en_grade_name}}</td>
                            <td>{{session('lang') == 'ar' ? $statement->division->ar_division_name : $statement->division->en_division_name}}</td>                            
                            <td>{{session('lang') == 'ar' ? $statement->regStatus->ar_name_status : $statement->regStatus->en_name_status}}</td>                                                        
                            <td>{{$statement->dd}}</td>
                            <td>{{$statement->mm}}</td>
                            <td>{{$statement->yy}}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>  
              </div> 
          </div>
        </div>
      </div>
    </div>      
</div>


@endsection
@section('script')

<script>
$(document).ready(function(){
  (function getDocumentSelected()
    {
      var id = "{{$student->id}}";
      
        $.ajax({
          type:'POST',
          url:'{{route("getDocumentSelected")}}',
      data: {
          _method : 'PUT',
          id      : id,
          _token  : '{{ csrf_token() }}'
        },
          dataType:'json',
          success:function(data){
            $('#documentId').html(data);
          }
        });
    }());

    (function getStepsSelected()
    {
      var id = "{{$student->id}}";
      
        $.ajax({
          type:'POST',
          url:'{{route("getStepsSelected")}}',
      data: {
          _method : 'PUT',
          id      : id,
          _token  : '{{ csrf_token() }}'
        },
          dataType:'json',
          success:function(data){
            $('#stepId').html(data);
          }
        });
    }());
})
$(document).ready(function(){
        (function(){
          var dob    = "{{$student->dob}}";
              $.ajax({
                type:'POST',
                url:'{{route("student.age")}}',
                data: {
                    _method     : 'PUT',
                    dob         : dob,              
                    _token      : '{{ csrf_token() }}'
                },
                success:function(response){
                  $('#dd').val(response.data.dd);
                  $('#mm').val(response.data.mm);
                  $('#yy').val(response.data.yy);            
                }
              })
        }())
      }) 
</script>
@endsection

