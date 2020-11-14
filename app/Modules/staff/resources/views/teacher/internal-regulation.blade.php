@extends('layouts.backEnd.dashboards.teacher')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{$title}}</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            {!! $internal->internal_regulation_text!!}
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
