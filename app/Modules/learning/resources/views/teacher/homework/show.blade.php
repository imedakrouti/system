@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
        .dropdown-item {    
            padding: 0.25rem 0.5rem;
        }        
    </style>
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title"><a href="{{route('teacher.homeworks')}}">{{ trans('learning::local.class_work') }}</a></h3>
    </div>    
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="card">
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">                              
                            <h4 class="red mb-2"><strong>{{$homework->title}}</strong></h4>  
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                      <div class="form-group row">
                          <label>{{ trans('learning::local.instruction') }}</label>                                                        
                          <textarea class="form-control" disabled name="instruction" cols="30" rows="10" >{{$homework->instruction}}</textarea>                                                      
                      </div>
                    </div>
     
                  </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    
                    <h5 class="mb-1"><strong>{{ trans('learning::local.subject') }} : </strong>
                        {{session('lang') == 'ar' ? $homework->subject->ar_name : $homework->subject->en_name}}</h5>
                        
                    <h5 class="mb-1"><strong>{{ trans('learning::local.due_date') }} : </strong>
                        @empty($homework->due_date)
                            {{ trans('learning::local.undefined') }}
                        @endempty
                        {{$homework->due_date}}
                    </h5>
                    <h5 class="mb-1"><strong>{{ trans('learning::local.total_mark') }} : </strong>{{$homework->total_mark}}</h5>

                    <h5><strong>{{ trans('learning::local.classrooms') }} : </strong></h5>
                    @foreach ($homework->classrooms as $classroom)
                        <div class="mb-1 badge badge-info">
                            <span><a target="_blank" href="{{route('posts.index',$classroom->id)}}">{{session('lang') == 'ar' ?$classroom->ar_name_classroom : $classroom->en_name_classroom}}</a></span>
                            <i class="la la-book font-medium-3"></i>
                        </div>
                    @endforeach

                    <h5><strong>{{ trans('learning::local.lessons') }} : </strong></h5>
                    @foreach ($homework->lessons as $lesson)
                        <div class="mb-1 badge badge-primary">
                            <span><a target="_blank" href="{{route('teacher.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id])}}">
                                {{$lesson->lesson_title}}</a></span>
                            <i class="la la-book font-medium-3"></i>
                        </div>
                    @endforeach
                    <hr>
                    @if ($homework->file_name != '')
                        <h5><strong>{{ trans('learning::local.attachments') }} : </strong>                    
                            <a target="_blank" href="{{asset('images/homework_attachments/'.$homework->file_name)}}" 
                            class="btn btn-primary btn-sm"><i class="la la-download"></i></a>
                        </h5>
                    @endif

                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
