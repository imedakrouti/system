@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('teacher.homeworks')}}">{{ trans('learning::local.class_work') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('homeworks.update',$homework->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')   
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.title') }}</label>                                                        
                                <input type="text" name="title" class="form-control" value="{{old('title',$homework->title)}}" required placeholder="{{ trans('learning::local.title') }}">
                                <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                          <div class="form-group row">
                              <label>{{ trans('learning::local.instruction') }}</label>                                                        
                              <textarea class="form-control" name="instruction" cols="30" rows="10" >{{old('instruction',$homework->instruction)}}</textarea>                          
                              <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                          </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                          <div class="form-group row">
                            <label>{{ trans('learning::local.upload_file') }}</label>
                            <input type="file" class="form-control" name="file_name">
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-lg-4">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                              <label>{{ trans('learning::local.share_with_class') }}</label>
                              <select name="classroom_id[]" class="form-control select2" id="filter_room_id" multiple required>
                                    @foreach (employeeClassrooms() as $class)
                                        <option  {{in_array( $class->id,$arr_classes) ? 'selected' : ''}}   value="{{$class->id}}">
                                        {{session('lang') == 'ar'? $class->ar_name_classroom : $class->en_name_classroom}}
                                        </option>
                                    @endforeach     
                              </select>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>  
    
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.lessons_related_assignment') }}</label>
                                <select name="lessons[]" class="form-control select2" multiple required>
                                    <option value="">{{ trans('staff::local.select') }}</option>
                                    @foreach ($lessons as $lesson)
                                        <option  {{in_array( $lesson->id,$arr_lessons) ? 'selected' : ''}}   value="{{$lesson->id}}">{{$lesson->lesson_title}} 
                                            [{{session('lang') == 'ar' ? $lesson->subject->ar_name : $lesson->subject->en_name}}]</option>
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
    
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                              <label>{{ trans('learning::local.subject') }}</label>
                              <select name="subject_id" class="form-control" required>                                
                                  @foreach (employeeSubjects() as $subject)
                                      <option {{old('subject_id',$homework->subject_id) == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                          {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                                  @endforeach
                              </select>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>                
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.due_date') }}</label>                                                        
                                <input type="date" name="due_date" class="form-control" value="{{old('due_date',$homework->due_date)}}">                            
                            </div>
                        </div>
    
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.total_mark') }}</label>
                                <input type="number" min="0"  name="total_mark" class="form-control" required  value="{{old('total_mark',$homework->total_mark)}}">
                                <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher.homeworks')}}';">
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