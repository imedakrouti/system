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
            <form class="form form-horizontal" method="POST" action="{{route('mothers.update',$mother->id)}}">
                @csrf                
                <div class="form-body">                    
                    @include('layouts.backEnd.includes._msg')
                    <h4 class="form-section"> {{ trans('student::local.mother_main_data') }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-2 label-control">{{ trans('student::local.mother_full_name') }}</label>
                              <div class="col-md-10">
                                <input type="text" class="form-control " value="{{old('full_name',$mother->full_name)}}" placeholder="{{ trans('student::local.mother_full_name') }}"
                                  name="full_name">
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
                                  <select name="id_type_m" class="form-control">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      <option {{old('id_type_m',$mother->id_type_m) == trans('student::local.national_id') ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                                      <option {{old('id_type_m',$mother->id_type_m) == trans('student::local.passport') ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                                  </select>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.id_number') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('id_number_m',$mother->id_number_m)}}" placeholder="{{ trans('student::local.id_number') }}"
                                  name="id_number_m">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.religion') }}</label>
                              <div class="col-md-9">                    
                                  <select name="religion_m" class="form-control">
                                    <option value="">{{ trans('student::local.select') }}</option>
                                    <option {{old('religion_m',$mother->religion_m) == 'muslim' ?'selected':''}} value="muslim">{{ trans('student::local.muslim_m') }}</option>
                                    <option {{old('religion_m',$mother->religion_m) == 'non_muslim' ?'selected':''}} value="non_muslim">{{ trans('student::local.non_muslim_m') }}</option>                                
                                </select>
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.nationality_id') }}</label>
                              <div class="col-md-9">
                                  <select name="nationality_id_m" class="form-control ">
                                      <option value="">{{ trans('student::local.select') }}</option>
                                      @foreach ($nationalities as $nationality)
                                          <option {{old('nationality_id_m',$mother->nationality_id_m) == $nationality->id ?'selected' : ''}} value="{{$nationality->id}}">{{$nationality->ar_name_nat_female}}</option>
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
                              <input type="text" class="form-control " value="{{old('job_m',$mother->job_m)}}" placeholder="{{ trans('student::local.job') }}"
                                name="job_m">
                                <span class="red">{{ trans('student::local.requried') }}</span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('student::local.qualification') }}</label>
                            <div class="col-md-9">
                              <input type="text" class="form-control " value="{{old('qualification_m',$mother->qualification_m)}}" placeholder="{{ trans('student::local.qualification') }}"
                                name="qualification_m">
                                <span class="red">{{ trans('student::local.requried') }}</span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('student::local.facebook') }}</label>
                            <div class="col-md-9">
                              <input type="text" class="form-control " value="{{old('facebook_m',$mother->facebook_m)}}" placeholder="{{ trans('student::local.facebook') }}"
                                name="facebook_m">
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('student::local.whatsapp_number') }}</label>
                            <div class="col-md-9">
                              <input type="text" class="form-control " value="{{old('whatsapp_number_m',$mother->whatsapp_number_m)}}" placeholder="{{ trans('student::local.whatsapp_number') }}"
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
                                <input type="number" min="0" class="form-control " value="{{old('home_phone_m',$mother->home_phone_m)}}" placeholder="{{ trans('student::local.home_phone') }}"
                                  name="home_phone_m">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.mobile1') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('mobile1_m',$mother->mobile1_m)}}" placeholder="{{ trans('student::local.mobile1') }}"
                                  name="mobile1_m">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.mobile2') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('mobile2_m',$mother->mobile2_m)}}" placeholder="{{ trans('student::local.mobile2') }}"
                                  name="mobile2_m">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.email') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('email_m',$mother->email_m)}}" placeholder="{{ trans('student::local.email') }}"
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
                                <input type="number" min="0" class="form-control " value="{{old('block_no_m',$mother->block_no_m)}}" placeholder="{{ trans('student::local.block_no') }}"
                                  name="block_no_m">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.street_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('street_name_m',$mother->street_name_m)}}" placeholder="{{ trans('student::local.street_name') }}"
                                  name="street_name_m">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.state') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('state_m',$mother->state_m)}}" placeholder="{{ trans('student::local.state') }}"
                                  name="state_m">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.government') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('government_m',$mother->government_m)}}" placeholder="{{ trans('student::local.government') }}"
                                  name="government_m">
                                  <span class="red">{{ trans('student::local.requried') }}</span>
                              </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('mother.show',$mother->id)}}';">
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
