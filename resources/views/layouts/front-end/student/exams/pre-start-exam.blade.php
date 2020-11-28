@extends('layouts.front-end.student.index')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="red center"><strong>{{$exam->exam_name}}</strong></h1>
                    <h5 class="black">
                        <strong>{{ trans('learning::local.subject_type') }} : </strong>
                        <span class="blue">{{session('lang') == 'ar' ? $exam->subjects->ar_name : $exam->subjects->en_name}}</span>                                                     
                    </h5>      
                    <h5 class="black">
                        <strong>{{ trans('learning::local.duration') }} : </strong>                            
                        <span class="blue"> {{$exam->duration}}</span>
                        {{ trans('learning::local.minute') }}
                    </h5>  
                    <div class="alert alert-info">
                        <h4 class="white">{{ trans('student.alert_start_exam') }}</h4>
                    </div>  
                    <div class="center">
                        <a href="{{route('student.start-exam',$exam->id)}}" class="btn btn-success">{{ trans('student.start_exam') }}</a>
                        <a href="{{route('student.exams')}}" class="btn btn-danger">{{ trans('student.back_to_exams') }}</a>
                    </div>         
                </div>           
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection