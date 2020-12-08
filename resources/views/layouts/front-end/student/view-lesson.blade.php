@extends('layouts.front-end.student.index')
@section('content')

<div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="card" style="min-height: 300px">
        <div class="card-content collapse show">
          <div class="card-body">
              <h2><strong>{{$lesson->lesson_title}}</strong></h2> 
              <p>{{$lesson->description}}</p>
              <div class="mb-1">
                @isset($lesson->video_url)              
                  <iframe width="100%"  style="min-height: 575px;" allowfullscreen
                      src="https://www.youtube.com/embed/{{prepareYoutubeURL($lesson->video_url)}}">
                  </iframe>
                @endisset
              </div>
              <div class="mb-2">
                @isset($lesson->file_name)                            
                  <video width="100%"  controls>
                        <source src="{{asset('images/lesson_attachments/'.$lesson->file_name)}}" type="video/mp4">
                        
                      Your browser does not support the video tag.
                      </video>
                @endisset
              </div>
                <div class="mt-2">                  
                  {!!$lesson->explanation!!}
                </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card" style="min-height: 300px">
          <div class="card-content collapse show">
            <div class="card-body">
                <h4>{{ trans('learning::local.attachments') }}</h4>                
                {{-- attachments --}}
                @if (count($lesson->files) > 0)       
                    <form action="" method="post" id="formData">
                      @csrf        
                      <ol>
                        @foreach ($lesson->files as $file)       
                            <li><a target="_blank" href="{{asset('images/lesson_attachments/'.$file->file_name)}}">{{$file->title}}</a>    </li>
                        @endforeach                                                                                          
                      </ol>              
                    </form>             
                @else
                    <h6>{{ trans('learning::local.no_attachments') }}</h6>
                @endif
                <hr>
                {{-- playlist --}}
                <h5><strong>{{ trans('learning::local.playlist') }} :</strong> <a href="{{route('student.show-lessons',$lesson->playlist_id)}}">{{$lesson->playlist->playlist_name}}</a></h5>
                <ol>
                  @foreach ($lessons as $lesson_playlist)              
                      @if ($lesson_playlist->id != $lesson->id)
                      <li>
                        <a href="{{route('student.view-lesson',['id'=>$lesson_playlist->id,'playlist_id' =>$lesson_playlist->playlist_id])}}">
                          {{$lesson_playlist->lesson_title}}</a>
                        {!!$lesson_playlist->visibility == 'hide' ? '<i class="la la-eye-slash"></i>' : ''!!}
                      </li>
                      @else
                          <li><strong>
                            {{$lesson_playlist->lesson_title}}
                            {!!$lesson_playlist->visibility == 'hide' ? '<i class="la la-eye-slash"></i>' : ''!!}
                          </strong></li>
                      @endif
                  @endforeach
                </ol>
                <hr>
                <div class="form-group">
                  <h6><strong>{{ trans('learning::local.subject_type') }} : </strong>{{session('lang') == 'ar' ? $lesson->subject->ar_name : $lesson->subject->en_name}}</h6>
                  <h6><strong>{{ trans('learning::local.created_by') }} : </strong>{{session('lang') == 'ar' ? $lesson->admin->ar_name : $lesson->admin->name}}</h6>
                  <h6><strong>{{ trans('learning::local.created_at') }} : </strong>{{$lesson->created_at->diffForHumans()}}</h6>                  
                </div>
                
                </h5>                
            </div>
          </div>
        </div>
      </div>
</div>
@endsection