@extends('layouts.backEnd.teacher')

@section('content')
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title">{{$title}}</h3>
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
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            @if (session('lang') == 'ar')
                {!! $internal->internal_regulation_text!!}              
            @else                
              {!! $internal->en_internal_regulation!!}              
            @endif
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
