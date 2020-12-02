@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('zoom-schedules.index')}}">{{ trans('learning::local.manage_zoom_schedule') }}</a>
            </li>                        
            <li class="breadcrumb-item">{{ $title }}</li>     
          </ol>
        </div>
      </div>
    </div>    
</div>

<div class="row mt-1">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <form class="form form-horizontal" method="POST" action="{{route('zoom-schedules.store')}}">
              @csrf
              <div class="form-body">
                  <h4 class="form-section"> {{ $title }}</h4>
                  @include('layouts.backEnd.includes._msg')  
                  <div class="row">
                  <div class="col-lg-9 col-md-12">
                        <div class="form-group">
                            <label>{{ trans('learning::local.topic') }}</label>
                            <input type="text" class="form-control" name="topic" value="{{old('topic')}}" 
                            placeholder="{{ trans('learning::local.topic') }}" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                        </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="form-group">
                        <label>{{ trans('learning::local.subject') }}</label>
                        <select name="subject_id" class="form-control" required>                                
                            @foreach (employeeSubjects() as $subject)
                                <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                    {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                            @endforeach
                        </select>
                        <span class="red">{{ trans('learning::local.required') }}</span>                              
                      </div>
                  </div>                  
                </div>                  
                  
                  <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('learning::local.date') }}</label>
                            <input type="date"  class="form-control " value="{{old('start_date')}}"
                              name="start_date" required>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('learning::local.time') }}</label>
                            <input type="time" class="form-control " value="{{old('start_time')}}"
                              name="start_time" required>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group"> 
                            <label>{{ trans('learning::local.classroom') }}</label>
                            <select name="classroom_id" class="form-control" id="filter_room_id" required>
                                <option value="">{{ trans('staff::local.select') }}</option>
                                @foreach (employeeClassrooms() as $classroom)
                                    <option {{old('classroom_id')==$classroom->id ? 'selected':''}}  value="{{$classroom->id}}">
                                        {{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}
                                    </option>
                                @endforeach                                    
                            </select>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                                                                                                                                                                                                                                                                                                         
                  </div>

                  <div class="col-lg-12 col-md-12">
                      <div class="form-group row">
                          <label>{{ trans('learning::local.notes') }}</label>
                          <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes')}}</textarea>                        
                      </div>
                  </div>                                                                             
              </div>
              <div class="form-actions left">
                  <button type="submit" class="btn btn-success">
                      <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                    </button>
                  <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('zoom-schedules.index')}}';">
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
