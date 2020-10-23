@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._main')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{ trans('admin.notifications') }}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('admin.notifications') }}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">                
                <a href="{{ route('read.notifications') }}" class="btn btn-social btn-min-width btn-facebook">
                    <span class="la la-eye font-medium-3"></span>{{trans('admin.mark_as_read')}} &nbsp;</a>
                <a href="{{ route('delete.notifications') }}" class="btn btn-social btn-min-width btn-pinterest">
                    <span class="la la-trash font-medium-3"></span>{{trans('admin.remove_all_notifications')}} &nbsp;</a>
            </div>
            <div class="card-content collapse show">
                <div class="card-body" style="max-height: 1000px; overflow: auto;">   
                    @foreach (auth()->user()->notifications as $notification)
                        <div class="bs-callout-{{$notification->data["color"]}} mb-1">
                            <div class="media align-items-stretch">
                                <div class="media-left media-middle bg-{{$notification->data["color"]}} p-2">
                                <i class="la la-{{ $notification->read_at==null?$notification->data["icon"]:'check' }} white font-medium-5 mb-1"></i>
                                </div>
                                <div class="media-body p-1">  
                                <strong>{{ $notification->data["title"] }}</strong>                              
                                <p>{!!$notification->data["data"]!!}</p>
                                <h6><strong>{{$notification->created_at->isoFormat(' dddd, Do MMMM  YYYY, h:mm')}}</strong></h6>
                                </div>
                            </div>
                        </div>                                    
                    @endforeach  
                    @if (auth()->user()->notifications->count() == 0)                        
                        <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                            <span class="alert-icon"><i class="la la-info-circle"></i></span>               
                            {{ trans('admin.no_notifications') }}
                        </div>
                    @endif       
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
