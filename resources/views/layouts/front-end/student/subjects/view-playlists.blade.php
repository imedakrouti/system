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
<h2 class=" mb-1">
    <strong>
        {{session('lang') == 'ar' ?                 
        $employee->ar_st_name .' ' .$employee->ar_nd_name.' '.$employee->ar_rd_name 
        : 
        $employee->en_st_name .' ' .$employee->en_nd_name.' '.$employee->en_rd_name}}         
    </strong>                   
</h2>



<div class="row mt-1">
    @empty(count($playlists))
    <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-info-circle"></i></span>               
        {{ trans('learning::local.no_playlists') }}
    </div>     
    @endempty

    <div class="col-lg-12 col-md-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <ul class="list-group">
                  @php
                      $n=1;
                  @endphp
                  @foreach ($playlists as $playlist) 
                    @foreach ($playlist->classes as $classroom)
                         @if ($classroom->id == classroom_id())
                            <li class="list-group-item">
                                
                                <span class="badge badge-info badge-pill float-right">{{ trans('student.lessons') }} {{$playlist->lessons->count()}}</span>
                                <a style="color: #464855;font-size:20px;font-weight:800" href="{{route('student.show-lessons',$playlist->id)}}">
                                   {{$n}} - {{$playlist->playlist_name}}</a>
                                <br>
                                <div class="mt-1 badge badge-primary">
                                    <span>{{session('lang') == 'ar' ? $playlist->subjects->ar_shortcut : $playlist->subjects->en_shortcut}}</span>
                                    <i class="la la-book font-medium-3"></i>
                                </div>
                            </li>
                        @endif
                    @endforeach
                        @php
                            $n++;
                        @endphp
                @endforeach  
              </ul>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection