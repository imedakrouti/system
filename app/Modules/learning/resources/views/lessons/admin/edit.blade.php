@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('lessons.index')}}">{{ trans('learning::local.lessons') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('lessons.update',$lesson->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')   
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group row">
                            <label>{{ trans('learning::local.playlists') }}</label>
                            <select name="playlist_id" class="form-control select2" required>
                                <option value="">{{ trans('staff::local.select') }}</option>
                                @foreach ($playlists as $play)
                                    <option {{old('playlist_id',$lesson->playlist_id) == $play->id ? 'selected' :''}} value="{{$play->id}}">
                                        {{$play->playlist_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @if (session('lang') == 'ar')
                                            [{{$play->employees->ar_st_name}} {{$play->employees->ar_nd_name}} {{$play->employees->ar_rd_name}} ]                                            
                                        @else
                                            [{{$play->employees->en_st_name}} {{$play->employees->en_nd_name}} {{$play->employees->en_rd_name}} ]                                            
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                              <label>{{ trans('learning::local.lesson_title') }}</label>
                              <input type="text" class="form-control " value="{{old('lesson_title',$lesson->lesson_title)}}" placeholder="{{ trans('learning::local.lesson_title') }}"
                                name="lesson_title" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>  
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                              <label>{{ trans('learning::local.description') }}</label>
                              <textarea name="description" class="form-control" cols="30" rows="5">{{old('description',$lesson->description)}}</textarea>                                
                            </div>
                        </div>                        
                    </div>                 
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                              <label>{{ trans('learning::local.visibility') }}</label>                              
                                <select name="visibility" class="form-control">
                                    <option {{old('visibility',$lesson->visibility) == 'show' ? 'selected' : ''}} value="show">{{ trans('learning::local.show') }}</option>
                                    <option {{old('visibility',$lesson->visibility) == 'hide' ? 'selected' : ''}} value="hide">{{ trans('learning::local.hide') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                              <label>{{ trans('learning::local.subject') }}</label>
                              <select name="subject_id" class="form-control select2" required>
                                  <option value="">{{ trans('staff::local.select') }}</option>
                                  @foreach ($subjects as $subject)
                                      <option {{old('subject_id',$lesson->subject_id) == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                          {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                                  @endforeach
                              </select>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                              <label>{{ trans('learning::local.sort_in_playlist') }}</label>
                              <input type="number" min="0" step="1" class="form-control " value="{{old('sort',$lesson->sort)}}" placeholder="{{ trans('learning::local.sort') }}"
                                name="sort" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>{{ trans('learning::local.division') }}</label>
                                <select name="division_id[]" class="form-control select2" required multiple>                                                                        
                                    @foreach ($divisions as $division)                                               
                                        <option {{in_array( $division->id,$arr_divisions) ? 'selected' : ''}} value="{{$division->id}}">
                                            {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}
                                        </option>                                                                                                                     
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group"> 
                                <label>{{ trans('learning::local.grade') }}</label>
                                <select name="grade_id[]" class="form-control select2" multiple required >                                    
                                    @foreach ($grades as $grade)                                               
                                        <option {{in_array( $grade->id,$arr_grades) ? 'selected' : ''}} value="{{$grade->id}}">
                                            {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}
                                        </option>                                                                                                                     
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>   
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group"> 
                                <label>{{ trans('student::local.year') }}</label>
                                <select name="year_id[]" class="form-control select2" multiple required>                           
                                    @foreach ($years as $year)                                               
                                        <option {{in_array( $year->id,$arr_years) ? 'selected' : ''}} value="{{$year->id}}">
                                            {{$year->name}}
                                        </option>                                                                                                                     
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>   
                    </div>               
                    <div class="col-lg-6 col-md-12">
                       <div class="form-group row">
                            <label>{{ trans('learning::local.video_url') }}</label>                           
                            <input type="text" name="video_url" class="form-control" value="{{old('video_url',$lesson->video_url)}}">
                            <div class="mt-2">
                                @isset($lesson->video_url)              
                                  <iframe width="400" height="300" 
                                      src="{{$lesson->video_url}}">
                                  </iframe>
                                @endisset
                              </div>
                        </div> 
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group row">  
                            <label>{{ trans('learning::local.upload_file_video') }}</label>                             
                            <input type="file" name="file_name" class="form-control">
                            <div class="mt-2">
                                @isset($lesson->file_name)                            
                                    <video width="55%" height="100%" controls>
                                        <source src="{{asset('images/lesson_attachments/'.$lesson->file_name)}}" type="video/mp4">
                                        
                                        Your browser does not support the video tag.
                                        </video>
                                @endisset
                            </div>                                                      
                        </div>
                    </div>  
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" name="remove_video" value="true">
                                <span class="lbl"></span> {{ trans('learning::local.remove_video') }}
                            </label>
                        </div>
                    </div>                  
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                              <label>{{ trans('learning::local.explanation') }}</label>
                              <textarea class="form-control" name="explanation" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('explanation',$lesson->explanation)}}</textarea>                          
                            </div>
                        </div>  
                    </div>  
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('lessons.index')}}';">
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
@section('script')
<script src="{{asset('cpanel/app-assets/vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('cpanel/app-assets/js/scripts/editors/editor-ckeditor.js')}}"></script>    
@endsection
