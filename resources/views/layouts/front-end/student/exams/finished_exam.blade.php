@extends('layouts.front-end.student.index')
@section('content')
  <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
      <span class="alert-icon"><i class="la la-info-circle"></i></span>               
      {{ trans('student.finished_exam') }}
  </div> 
@endsection