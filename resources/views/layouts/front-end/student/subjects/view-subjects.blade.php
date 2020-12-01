@extends('layouts.front-end.student.index')
@section('styles')
    <style>
        .maincontainer
        {
            width: 302px;
            height: 299px;
            margin: 10px;
            float: left; /* stack each div horizontally */
        }

        img
        {
          border-radius: 10px;
        }

        .back h2
        {
            position: absolute;
        }

        .back p
        {
            position: absolute;
            top: 50px;
            font-size: 15px;
        }

        .front h2
        {
            position: absolute;
            padding: 10px;
            top: 193px;
            left: 88px;
            color: #fff;
            font-weight: 800;
        }

        /* style the maincontainer class with all child div's of class .front */
        .maincontainer > .front
        {
            position: absolute;
            transform: perspective(600px) rotateY(0deg);
            
            width: 302px;
            height: 290px;
            
            backface-visibility: hidden; /* cant see the backside elements as theyre turning around */
            transition: transform .5s linear 0s;
        }

        /* style the maincontainer class with all child div's of class .back */
        .maincontainer > .back
        {
            position: absolute;
            transform: perspective(600px) rotateY(180deg);
            background: #084872;
            color: #fff;
            width: 302px;
            height: 290px;
            border-radius: 10px;
            padding: 10px;
            backface-visibility: hidden; /* cant see the backside elements as theyre turning around */
            transition: transform .5s linear 0s;
        }

        .maincontainer:hover > .front
        {
            transform: perspective(600px) rotateY(-180deg);
        }

        .maincontainer:hover > .back
        {
            transform: perspective(600px) rotateY(0deg);
        }
        a:hover{
          font-weight: 800
        }

               
    </style>
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>      
    </div>      
</div>
<div class="row mt-1">
  @foreach ($subjects as $subject) 
  <div style="{{session('lang') == 'ar'?'margin-right:25px':'margin-left:25px'}}">
      <div class="maincontainer">
          <div class="back">
              <h2 class="white"><strong>{{session('lang') == 'ar' ?$subject->ar_name:$subject->en_name}}</strong>
              <span style="font-size: 16px">{{ trans('student.playlists') }} {{$subject->playlist->count()}}</span>
              </h2>
              <h3 class="white mt-3">                    
              @foreach ($subject->employees as $employee)
                @foreach ($employee->classrooms as $classroom)
                    @if ($classroom->id == classroom_id())
                      <i class="la la-user font-medium-3"></i>
                      {{session('lang') == 'ar' ?                 
                        $employee->ar_st_name .' ' .$employee->ar_nd_name : 
                        $employee->en_st_name .' ' .$employee->en_nd_name}}                      
                    @endif                    
                @endforeach
                <h4 class="white"><strong>{{ trans('student.last_lessons') }}</strong></h4>             
                <ul class="lessons" style="list-style: circle">
                      @foreach ($subject->lessons as $lesson)
                          <li>
                            <a href="{{route('student.view-lesson',['id'=>$lesson->id, 'playlist_id' =>$lesson->playlist_id])}}" 
                              style="color: #fff;" href="#">
                              {{$lesson->lesson_title}}</a> <br> 
                            <span class="small"><i class="la la-clock-o"></i> {{$lesson->created_at->diffForHumans()}}</span>
                          </li>
                      @endforeach
                </ul>
              @endforeach
              </h3> 
          </div>
          <div class="front">
              <div class="image">
              <img src="{{asset('images/website/sub.png')}}">
              <h2 class="white">{{session('lang') == 'ar' ?$subject->ar_name:$subject->en_name}}
              {{-- <span style="display: block;font-size: 18px;">{{ trans('student.playlists') }} {{$subject->playlist->count()}}</span> --}}
              </h2>
            
              
              </div>
          </div>
      </div>
  </div>

    {{-- <div class="col-lg-6 col-md-12">
      <div class="card overflow-hidden">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="bg-info p-2 media-middle">              
              <i class="la la-book font-large-2 text-white"></i>
            </div>
            <div class="media-body p-2">
              <h4>{{session('lang') == 'ar' ?$subject->ar_name:$subject->en_name}}</h4>
              @foreach ($subject->employees as $employee)
                  @foreach ($employee->classrooms as $classroom)
                    @if ($classroom->id == classroom_id())
                        <h4 class="blue">                    
                            <a href="{{route('student.playlists',$employee->id)}}">
                                <i class="la la-user font-medium-3"></i>
                                {{session('lang') == 'ar' ?                 
                            $employee->ar_st_name .' ' .$employee->ar_nd_name.' '.$employee->ar_rd_name  : 
                            $employee->en_st_name .' ' .$employee->en_nd_name.' '.$employee->en_rd_name}}</a>                        
                        </h4>              
                    @endif                    
                  @endforeach
              @endforeach
            </div>
            <div class="media-right p-2 media-middle">
              <h1 class="info"><a href="{{route('student.playlists',$employee->id)}}">{{$subject->playlist->count()}}</a></h1>
              <h5 class="info"><a href="{{route('student.playlists',$employee->id)}}">{{ trans('student.playlists') }}</a></h5>
            </div>
          </div>
        </div>
      </div>
    </div> 
     --}}
    @endforeach    
</div>
@endsection
@section('script')
    <script>
      $('ul.lessons li').hide().slice(0, 2).show();      
    </script>
@endsection