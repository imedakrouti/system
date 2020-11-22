@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
            /* Top left text */
            .top-left {
            position: absolute;
            top: 50px;
            left: 70px;
            color: aliceblue
}            
    </style>
@endsection
@section('content')
{{-- images --}}
<div class="row">
    <div class="col-lg-12 mb-1">
        <img src="{{asset('images/website/img_code.jpg')}}" width="100%" alt="cover">    
        <h1 class="top-left"><strong>{{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}</strong></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title" id="heading-icon-dropdown"><strong>{{ trans('learning::local.upcoming') }}</strong></h4>
          </div>
          <div class="card-content">
            <div class="card-body">              
              <p class="card-text">{{ trans('learning::local.no_works') }}</p>              
            </div>
          </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12">
        {{-- posts --}}
        <div class="col-md-12 col-sm-12 mb-1">
            <div class="card">
                <div class="card-header">
                
                <h4 class="card-title" id="heading-icon-dropdown">
                    <span class="avatar avatar-online">
                        @isset(authInfo()->image_profile)
                          <img src="{{asset('images/imagesProfile/'.authInfo()->image_profile)}}" alt="avatar">                          
                        @endisset
                        @empty(authInfo()->image_profile)                          
                          <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
                        @endempty
                    </span>
                    With Icon &amp; Dropdown</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <button type="button" class="btn btn-round " data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="la la-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item pb-1" href="#">{{ trans('learning::local.edit') }}</a>
                        <a class="dropdown-item" href="#">{{ trans('admin.delete') }}</a>                        
                    </div>
                </div>
                </div>
                <div class="card-content">
                <div class="card-body">                    
                    <p class="card-text">Jelly beans sugar plum cheesecake cookie oat cake soufflé.Tootsie
                    roll bonbon liquorice tiramisu pie powder.Donut sweet roll
                    marzipan pastry cookie cake tootsie roll oat cake cookie.</p>                          
                </div>
                </div>
            </div>
        </div>  

        
    </div>    
</div>


@endsection
