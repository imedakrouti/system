@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('teacher.playlists')}}">{{ trans('learning::local.playlist') }}</a>
            </li>       
            <li class="breadcrumb-item">{{$title}}
            </li>       
            
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
            <form class="form form-horizontal" method="POST" action="{{route('teacher.update-playlists',$playlist->id)}}" enctype="multipart/form-data">
              @csrf
              <div class="form-body">
                  <h4 class="form-section"> {{ $title }}</h4>
                  @include('layouts.backEnd.includes._msg')   
                  <div class="col-lg-4 col-md-12">
                    <div class="form-group row">
                        <label>{{ trans('learning::local.playlist_name') }}</label>
                        <input type="text" class="form-control" name="playlist_name" value="{{old('playlist_name',$playlist->playlist_name)}}">
                        <span class="red">{{ trans('learning::local.required') }}</span>                              
                    </div>
                </div>                  
                <div class="col-lg-4 col-md-6">
                    <div class="form-group row">
                      <label>{{ trans('learning::local.subject') }}</label>
                      <select name="subject_id" class="form-control" required>
                          @foreach (employeeSubjects() as $subject)
                              <option {{old('subject_id',$playlist->subject_id) == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                  {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                          @endforeach
                      </select>
                      <span class="red">{{ trans('learning::local.required') }}</span>                              
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group row">
                      <label>{{ trans('learning::local.sort') }}</label>
                      <input type="number" min="0" class="form-control " value="{{old('sort',$playlist->sort)}}" placeholder="{{ trans('learning::local.sort') }}"
                        name="sort" required>
                        <span class="red">{{ trans('learning::local.required') }}</span>                              
                    </div>
                </div>                                                                     
              </div>
              <div class="form-actions left">
                  <button type="submit" class="btn btn-success">
                      <i class="la la-check-square-o"></i> {{ trans('admin.save_changes') }}
                    </button>
                  <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher.show-lessons',$playlist->id)}}';">
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
