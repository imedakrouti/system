@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('timetables.index')}}">{{ trans('staff::local.timetables') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('timetables.update',$timetable->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <h4 class="blue">{{ trans('staff::local.timetable_data') }}</h4>
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.ar_timetable') }}</label>
                            <input type="text" class="form-control " value="{{old('ar_timetable',$timetable->ar_timetable)}}" 
                            placeholder="{{ trans('staff::local.ar_timetable') }}"
                              name="ar_timetable" required>
                              <span class="red">{{ trans('staff::local.required') }}</span>                          
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.en_timetable') }}</label>
                            <input type="text" class="form-control " value="{{old('en_timetable',$timetable->en_timetable)}}" 
                            placeholder="{{ trans('staff::local.en_timetable') }}"
                              name="en_timetable" required>
                              <span class="red">{{ trans('staff::local.required') }}</span>                          
                          </div>
                      </div>
                    </div> 
                    
                    <div class="col-lg-8 col-md-12">
                      <div class="form-group row">
                        <label>{{ trans('staff::local.description') }}</label>
                          <textarea name="description" class="form-control" cols="30" rows="5">{{old('description',$timetable->description)}}</textarea>
                          <span class="red">{{ trans('staff::local.required') }}</span>                          
                      </div>
                    </div>

                    <hr>

                    <h4 class="blue">{{ trans('staff::local.attendance_data') }}</h4>

                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.on_duty_time') }}</label>
                            <input type="time" class="form-control " value="{{old('on_duty_time',$timetable->on_duty_time)}}"                             
                              name="on_duty_time" required>
                              <span class="red">{{ trans('staff::local.required') }}</span>                          
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.off_duty_time') }}</label>
                          <input type="time" class="form-control " value="{{old('off_duty_time',$timetable->off_duty_time)}}"                             
                            name="off_duty_time" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                      </div>                      
                    </div> 

                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.beginning_in') }}</label>
                            <input type="time" class="form-control " value="{{old('beginning_in',$timetable->beginning_in)}}"                             
                              name="beginning_in" required>
                              <span class="red">{{ trans('staff::local.required') }}</span>                          
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.ending_in') }}</label>
                          <input type="time" class="form-control " value="{{old('ending_in',$timetable->ending_in)}}"                             
                            name="ending_in" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                      </div>                      
                    </div>  
                    
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.beginning_out') }}</label>
                            <input type="time" class="form-control " value="{{old('beginning_out',$timetable->beginning_out)}}"                             
                              name="beginning_out" required>
                              <span class="red">{{ trans('staff::local.required') }}</span>                          
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.ending_out') }}</label>
                          <input type="time" class="form-control " value="{{old('ending_out',$timetable->ending_out)}}"                             
                            name="ending_out" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                      </div>                      
                    </div>  
                    
                    <div class="col-lg-8 col-md-12">
                      <div class="form-group row">
                        <label>{{ trans('staff::local.working_days') }}</label> <br>
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="saturday" value="Enable" 
                              {{old('saturday',$timetable->saturday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.saturday') }}
                          </label> 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="sunday" value="Enable"
                              {{old('sunday',$timetable->sunday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.sunday') }}
                          </label>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="monday" value="Enable"
                              {{old('monday',$timetable->monday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.monday') }}
                          </label>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="tuesday" value="Enable"
                              {{old('tuesday',$timetable->tuesday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.tuesday') }}
                          </label>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="wednesday" value="Enable"
                              {{old('wednesday',$timetable->wednesday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.wednesday') }}
                          </label>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="thursday" value="Enable"
                              {{old('thursday',$timetable->thursday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.thursday') }}
                          </label>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label class="pos-rel"><br>
                              <input type="checkbox" class="ace" name="friday" value="Enable"
                              {{old('friday',$timetable->friday) == 'Enable' ? 'checked' : ''}}>
                              <span class="lbl"></span> {{ trans('staff::local.friday') }}
                          </label>                                                                                                                                   
                      </div>
                    </div>
                    <hr>

                    <h4 class="blue">{{ trans('staff::local.absent_deductions') }}</h4>
                    <div class="row">
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.saturday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('saturday_value',$timetable->saturday_value)}}"                             
                              name="saturday_value" required>                         
                        </div>
                      </div>
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.sunday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('sunday_value',$timetable->sunday_value)}}"                             
                              name="sunday_value" required>                         
                        </div>
                      </div>
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.monday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('monday_value',$timetable->monday_value)}}"                             
                              name="monday_value" required>                         
                        </div>
                      </div>
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.tuesday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('tuesday_value',$timetable->tuesday_value)}}"                             
                              name="tuesday_value" required>                         
                        </div>
                      </div>
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.wednesday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('wednesday_value',$timetable->wednesday_value)}}"                             
                              name="wednesday_value" required>                         
                        </div>
                      </div>
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.thursday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('thursday_value',$timetable->thursday_value)}}"                             
                              name="thursday_value" required>                         
                        </div>
                      </div>
                      <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                          <label>{{ trans('staff::local.friday') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('friday_value',$timetable->friday_value)}}"                             
                              name="friday_value" required>                         
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.daily_late_minutes') }}</label>
                            <input type="number" min="0" class="form-control " value="{{old('daily_late_minutes',$timetable->daily_late_minutes)}}"                             
                              name="daily_late_minutes" required>                              
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.day_absent_value') }}</label>
                          <input type="number" min="0" step="0.25" class="form-control " value="{{old('day_absent_value',$timetable->day_absent_value)}}"                             
                            name="day_absent_value" required>                            
                        </div>
                      </div>                      
                    </div>  

                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('staff::local.no_attend') }}</label>
                            <input type="number" min="0" class="form-control " value="{{old('no_attend',$timetable->no_attend)}}"                             
                              name="no_attend" required>                              
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.no_leave') }}</label>
                          <input type="number" min="0" step="0.25" class="form-control " value="{{old('no_leave',$timetable->no_leave)}}"                             
                            name="no_leave" required>                            
                        </div>
                      </div>                      
                    </div> 

                    <div class="col-lg-3 col-md-6">
                      <div class="form-group row">
                        <label>{{ trans('staff::local.check_in_before_leave') }}</label>
                        <input type="number" min="0" class="form-control " step="0.25" value="{{old('check_in_before_leave',$timetable->check_in_before_leave)}}"                             
                          name="check_in_before_leave" required>                              
                      </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('timetables.index')}}';">
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
