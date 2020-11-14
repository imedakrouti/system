@extends('layouts.backEnd.dashboards.teacher')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">                          
                @if(count($announcements) > 0)
                    @foreach ($announcements as $announcement)              
                        <div class="col-lg-12 col-md-12">
                        <div class="card box-shadow-0 border-info bg-transparent">
                            <div class="card-header bg-transparent">
                            <h4 class="card-title">
                                {{session('lang') == 'ar' ? $announcement->admin->ar_name : $announcement->admin->name}} | 
                                    <span class="blue" style="font-size: 12px;">{{$announcement->created_at->diffForHumans()}}</span>              
                            </h4>
                            </div>
                            <div class="card-content collapse show">
                            <div class="card-body">                                                                                                               
                                <p class="card-text">{!!$announcement->announcement!!}</p>                     
                            </div>
                            </div>
                        </div>
                        </div>                
                    @endforeach
                @else                
                    <div class="col-lg-12 col-md-12">
                        <div class="card box-shadow-0 border-info bg-transparent">
                        <div class="card-content collapse show">
                            <div class="card-body">                                                                                                               
                            <p class="card-text">{{ trans('staff::local.no_announcements') }}</p>                     
                            </div>
                        </div>
                        </div>
                    </div>
                @endif                          
          </div>
        </div>
      </div>
    </div>
</div>


@endsection
