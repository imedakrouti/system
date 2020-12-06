@extends('layouts.front-end.student.index')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title"><a href="{{route('student.homeworks')}}">{{ trans('learning::local.class_work') }}</a></h3>
        <div class="row breadcrumbs-top">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">                 
              <li class="breadcrumb-item active">{{$title}}
              </li>
            </ol>
          </div>
        </div>
    </div>    
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h3><strong>{{$homework->title}}</strong></h3>
                <p class="card-text" style="white-space: pre-line">{!!$homework->instruction!!}</p>
                <form action="{{route('student.store-homework')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="homework_id" value="{{$homework->id}}">
                    <div class="form-group">
                        <label>{{ trans('student.your_answer') }}:</label>
                        <textarea required name="user_answer" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <input type="file" name="file_name" class="form-control">
                    <div class="form-actions left">
                        <button type="submit" class="btn btn-success">
                            <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                          </button>
                        <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('student.homeworks')}}';">
                        <i class="ft-x"></i> {{ trans('admin.cancel') }}
                      </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5><strong>{{ trans('student.expire_date') }} : </strong>{{\Carbon\Carbon::parse( $homework->due_date)->format('M d Y, D  ')}}</h5>
                <h5><strong>{{ trans('student.subject') }} : </strong>
                    {{session("lang") == "ar" ? $homework->subject->ar_name : $homework->subject->en_name}}</h5>
                <h5><strong>{{ trans('student.lessons') }} : </strong>
                </h5>
                <ol>
                    @foreach ($homework->lessons as $lesson)
                        <li><a target="_blank" href="{{route('student.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id])}}">{{$lesson->lesson_title}}</a> </li>
                    @endforeach
                </ol>
                <hr>
                <h5><strong>{{ trans('student::local.attachements') }} : </strong>
                {!!empty($homework->file_name) ? '':'<a target="_blank"  href="'.asset('images/homework_attachments/'.$homework->file_name).'"
                    class="btn btn-primary btn-sm" href="#"><i class=" la la-download"></i></a>'!!}
                </h5>
            </div>
        </div>
    </div>
</div>


@endsection