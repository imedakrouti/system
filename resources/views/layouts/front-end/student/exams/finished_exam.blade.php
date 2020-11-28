@extends('layouts.front-end.student.index')
@section('content')
<div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <h5 class="red">{{ trans('student.finished_exam') }}</h5>       
        </div>
      </div>
    </div>
  </div>
@endsection