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
            <li class="breadcrumb-item"><a href="{{route('parents.index')}}">{{ trans('student::local.parents') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('fathers.update',$father->id)}}">
                @csrf                
                <div class="form-body">                    
                    @include('layouts.backEnd.includes._msg')
                    <h4 class="form-section"> {{ trans('student::local.father_main_data') }}</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.ar_st_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_st_name',$father->ar_st_name)}}" placeholder="{{ trans('student::local.ar_st_name') }}"
                                  name="ar_st_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.ar_nd_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_nd_name',$father->ar_nd_name)}}" placeholder="{{ trans('student::local.ar_nd_name') }}"
                                  name="ar_nd_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.ar_rd_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_rd_name',$father->ar_rd_name)}}" placeholder="{{ trans('student::local.ar_rd_name') }}"
                                  name="ar_rd_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.ar_th_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_th_name',$father->ar_th_name)}}" placeholder="{{ trans('student::local.ar_th_name') }}"
                                  name="ar_th_name">
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
                                <input type="text" class="form-control " value="{{old('en_st_name',$father->en_st_name)}}" placeholder="{{ trans('student::local.en_st_name') }}"
                                  name="en_st_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.en_nd_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('en_nd_name',$father->en_nd_name)}}" placeholder="{{ trans('student::local.en_nd_name') }}"
                                  name="en_nd_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.en_rd_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('en_rd_name',$father->en_rd_name)}}" placeholder="{{ trans('student::local.en_rd_name') }}"
                                  name="en_rd_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.en_th_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('en_th_name',$father->en_th_name)}}" placeholder="{{ trans('student::local.en_th_name') }}"
                                  name="en_th_name">
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
                                  <select name="id_type" class="form-control">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      <option {{old('id_type',$father->id_type) == trans('student::local.national_id') ||
                                      old('id_type',$father->id_type) == 'national_id'
                                      ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                                      <option {{old('id_type',$father->id_type) == trans('student::local.passport') ||
                                      old('id_type',$father->id_type) == 'passport'
                                      ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                                  </select>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.id_number') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('id_number',$father->id_number)}}" placeholder="{{ trans('student::local.id_number') }}"
                                  name="id_number">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.religion') }}</label>
                              <div class="col-md-9">                    
                                  <select name="religion" class="form-control">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      <option {{old('religion',$father->religion) == 'muslim' ?'selected':''}} value="muslim">{{ trans('student::local.muslim') }}</option>
                                      <option {{old('religion',$father->religion) == 'non_muslim' ?'selected':''}} value="non_muslim">{{ trans('student::local.non_muslim') }}</option>                                
                                  </select>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.nationality_id') }}</label>
                              <div class="col-md-9">
                                  <select name="nationality_id" class="form-control ">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      @foreach ($nationalities as $nationality)
                                          <option {{old('nationality_id',$father->nationality_id) == $nationality->id ?'selected' : ''}} value="{{$nationality->id}}">{{$nationality->ar_name_nat_male}}</option>
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
                              <input type="text" class="form-control " value="{{old('job',$father->id)}}" placeholder="{{ trans('student::local.job') }}"
                                name="job">
                                <span class="red">{{ trans('student::local.requried') }}</span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('student::local.qualification') }}</label>
                            <div class="col-md-9">
                              <input type="text" class="form-control " value="{{old('qualification',$father->qualification)}}" placeholder="{{ trans('student::local.qualification') }}"
                                name="qualification">
                                <span class="red">{{ trans('student::local.requried') }}</span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('student::local.facebook') }}</label>
                            <div class="col-md-9">
                              <input type="text" class="form-control " value="{{old('facebook',$father->facebook)}}" placeholder="{{ trans('student::local.facebook') }}"
                                name="facebook">
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('student::local.whatsapp_number') }}</label>
                            <div class="col-md-9">
                              <input type="text" class="form-control " value="{{old('whatsapp_number',$father->whatsapp_number)}}" placeholder="{{ trans('student::local.whatsapp_number') }}"
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
                                <input type="number" min="0" class="form-control " value="{{old('home_phone',$father->home_phone)}}" placeholder="{{ trans('student::local.home_phone') }}"
                                  name="home_phone">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.mobile1') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('mobile1',$father->mobile1)}}" placeholder="{{ trans('student::local.mobile1') }}"
                                  name="mobile1">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.mobile2') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('mobile2',$father->mobile2)}}" placeholder="{{ trans('student::local.mobile2') }}"
                                  name="mobile2">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.email') }}</label>
                              <div class="col-md-9">
                                <input type="email" class="form-control " value="{{old('email',$father->email)}}" placeholder="{{ trans('student::local.email') }}"
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
                                <input type="number" min="0" class="form-control " value="{{old('block_no',$father->block_no)}}" placeholder="{{ trans('student::local.block_no') }}"
                                  name="block_no">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.street_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('street_name',$father->street_name)}}" placeholder="{{ trans('student::local.street_name') }}"
                                  name="street_name">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.state') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('state',$father->state)}}" placeholder="{{ trans('student::local.state') }}"
                                  name="state">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.government') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('government',$father->government)}}" placeholder="{{ trans('student::local.government') }}"
                                  name="government">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                    </div> 
                    <h4 class="form-section"> {{ trans('student::local.extra_info') }}</h4> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.educational_mandate') }}</label>
                              <div class="col-md-9">                    
                                  <select name="educational_mandate" class="form-control">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      <option {{old('educational_mandate',$father->educational_mandate) == trans('student::local.father') ||
                                                old('educational_mandate',$father->educational_mandate) == 'father'
                                      ?'selected':''}} value="father">{{ trans('student::local.father') }}</option>
                                      <option {{old('educational_mandate',$father->educational_mandate) == trans('student::local.mother') ||
                                                old('educational_mandate',$father->educational_mandate) == 'mother'
                                      ?'selected':''}} value="mother">{{ trans('student::local.mother') }}</option>                                                                                                                  
                                  </select>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>                                         
                    </div>  
                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.marital_status') }}</label>
                              <div class="col-md-9">                    
                                  <select name="marital_status" class="form-control">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      <option {{old('marital_status',$father->marital_status) == trans('student::local.married') ||
                                                old('marital_status',$father->marital_status) == 'married' 
                                      ?'selected':''}} value="married">{{ trans('student::local.married') }}</option>
                                      <option {{old('marital_status',$father->marital_status) == trans('student::local.divorced') ||
                                                old('marital_status',$father->marital_status) == 'divorced' 
                                      ?'selected':''}} value="divorced">{{ trans('student::local.divorced') }}</option>                                
                                      <option {{old('marital_status',$father->marital_status) == trans('student::local.separated') ||
                                                old('marital_status',$father->marital_status) == 'separated' 
                                      ?'selected':''}} value="separated">{{ trans('student::local.separated') }}</option>                                
                                      <option {{old('marital_status',$father->marital_status) == trans('student::local.widower') ||
                                                old('marital_status',$father->marital_status) == 'widower' 
                                      ?'selected':''}} value="widower">{{ trans('student::local.widower') }}</option>
                                  </select>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>                        
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.recognition') }}</label>
                              <div class="col-md-9">                    
                                  <select name="recognition" class="form-control">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      <option {{old('recognition',$father->recognition) == trans('student::local.facebook') ||
                                      old('recognition',$father->recognition) == 'facebook'
                                      ?'selected':''}} value="facebook">{{ trans('student::local.fb') }}</option>
                                      <option {{old('recognition',$father->recognition) == trans('student::local.parent') ||
                                      old('recognition',$father->recognition) == 'parent'
                                      ?'selected':''}} value="parent">{{ trans('student::local.parent') }}</option>                                
                                      <option {{old('recognition',$father->recognition) == trans('student::local.street') ||
                                      old('recognition',$father->recognition) == 'street'
                                      ?'selected':''}} value="street">{{ trans('student::local.street') }}</option>                                
                                      <option {{old('recognition',$father->recognition) == trans('student::local.school_hub') ||
                                      old('recognition',$father->recognition) == 'school_hub'
                                      ?'selected':''}} value="school_hub">{{ trans('student::local.school_hub') }}</option>
                                  </select>
                              </div>
                            </div>
                        </div>                        
                    </div>                      
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('father.show',$father->id)}}';">
                    <i class="ft-x"></i> {{ trans('admin.cancel') }}
                  </button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
