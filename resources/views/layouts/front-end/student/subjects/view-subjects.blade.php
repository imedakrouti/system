@extends('layouts.front-end.student.index')
@section('styles')
    <style>
        .shadow{
            /* text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.7); */
            color: #194872;
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

    <div class="col-lg-6 col-md-12">
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
    
    @endforeach    
</div>
@endsection