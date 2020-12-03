@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">      
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>            
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="col-md-6 col-sm-12">
  <div class="card text-white bg-gradient-y-blue box-shadow-0">
    <div class="card-header">
      <h4 class="card-title text-white">Custom background Gradient</h4>
      <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <p class="card-text">This example uses the same vertical gradient class with custom
          color background.</p>
        <p class="card-text">Oat cake ice cream candy chocolate cake chocolate cake cotton
          candy dragée apple pie. Brownie carrot cake candy canes bonbon
          fruitcake topping halvah. Cake sweet roll cake cheesecake cookie
          chocolate cake liquorice. Apple pie sugar plum powder donut
          soufflé.
        </p>
      </div>
    </div>
  </div>
</div>
<div class="col-md-6 col-sm-12">
  <div class="card text-white bg-gradient-y-blue box-shadow-0">
    <div class="card-header">
      <h4 class="card-title text-white">Custom background Gradient</h4>
      <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <p class="card-text">This example uses the same vertical gradient class with custom
          color background.</p>
        <p class="card-text">Oat cake ice cream candy chocolate cake chocolate cake cotton
          candy dragée apple pie. Brownie carrot cake candy canes bonbon
          fruitcake topping halvah. Cake sweet roll cake cheesecake cookie
          chocolate cake liquorice. Apple pie sugar plum powder donut
          soufflé.
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
