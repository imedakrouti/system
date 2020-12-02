@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
    </div>    
</div>
<div class="row mt-1">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
              <form class="form form-horizontal" method="POST" action="{{route('zoom.store-account')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>              
                    @include('layouts.backEnd.includes._msg')  
                    <input type="hidden" name="employee_id" value="{{employee_id()}}"> 
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                  <label>{{ trans('learning::local.meeting_id') }}</label>
                                  <input type="number" min="0" class="form-control " value="{{old('meeting_id',empty($account->meeting_id)?'':$account->meeting_id)}}" placeholder="{{ trans('learning::local.meeting_id') }}"
                                    name="meeting_id" required>
                                    <span class="red">{{ trans('learning::local.required') }}</span>                              
                                </div>
                            </div>  
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                  <label>{{ trans('learning::local.pass_code') }}</label>
                                  <input type="text" class="form-control " value="{{old('pass_code',empty($account->pass_code)?'':$account->pass_code)}}" placeholder="{{ trans('learning::local.pass_code') }}"
                                    name="pass_code" required>
                                    <span class="red">{{ trans('learning::local.required') }}</span>                              
                                </div>
                            </div>                              
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="bs-callout-info callout-border-left mb-1 p-1">
                                <strong>What is a Zoom meeting ID?</strong>
                                <p>A meeting ID is the 10-digit meeting number associated with an instant or scheduled meeting. When a meeting is created, Zoom generates a meeting ID and each ID number is individual to each meeting that is created.

                                    When you join a meeting, you are prompted for the Meeting ID number. This number is located in the Meeting request..
                                </p>
                            </div>  
                            <div class="bs-callout-info callout-border-left mb-1 p-1">
                                <strong>Passcode</strong>
                                <p>Zoom account to require passcodes for your own meetings.</p>
                                <P>The student cannot attend any virtual class without obtaining the passcode .. 
                                    The system will send the password to students according to the schedule specified for the virtual classes</P>
                            </div>                                                         
                        </div>
                    </div>                    
                                                                                                                                                                        
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('dashboard.teacher')}}';">
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