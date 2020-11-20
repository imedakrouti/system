@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('exams.index')}}">{{ trans('learning::local.exams') }}</a></li>
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
          <div class="card-body">
            <form class="form form-horizontal" method="POST" action="{{route('exams.update',$exam->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')   
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group row">
                            <label>{{ trans('learning::local.exam_name') }}</label>
                            <input type="text" class="form-control" name="exam_name" value="{{old('exam_name',$exam->exam_name)}}" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                      <div class="form-group row">
                          <label>{{ trans('learning::local.lessons_related_exam') }}</label>
                          <select name="lessons[]" class="form-control select2" multiple>
                              <option value="">{{ trans('staff::local.select') }}</option>
                              @foreach ($lessons as $lesson)
                                  <option {{in_array( $lesson->id,$arr_lessons) ? 'selected' : ''}} value="{{$lesson->id}}">{{$lesson->lesson_title}} 
                                      [{{session('lang') == 'ar' ? $lesson->subject->ar_name : $lesson->subject->en_name}}]</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                      <div class="form-group row">
                        <label>{{ trans('learning::local.subject') }}</label>
                        <select name="subject_id" class="form-control select2" required>
                            <option value="">{{ trans('staff::local.select') }}</option>
                            @foreach ($subjects as $subject)
                                <option {{old('subject_id',$exam->subject_id) == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                    {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                            @endforeach
                        </select>
                        <span class="red">{{ trans('learning::local.required') }}</span>                              
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.start_date') }}</label>
                              <input type="date"  class="form-control " value="{{old('start_date',$exam->start_date)}}"
                                name="start_date" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.start_time') }}</label>
                              <input type="time" class="form-control " value="{{old('start_time',$exam->start_time)}}"
                                name="start_time" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>                                                                                                                                 
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.end_date') }}</label>
                              <input type="date"  class="form-control " value="{{old('end_date',$exam->end_date)}}"
                                name="end_date" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.end_time') }}</label>
                              <input type="time" class="form-control " value="{{old('end_time',$exam->end_time)}}"
                                name="end_time" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>                                                                                                                                 
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.exam_duration') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('duration',$exam->duration)}}"
                                name="duration" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.total_mark') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('total_mark',$exam->total_mark)}}"
                                name="total_mark" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>    
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.no_question_per_page') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('no_question_per_page',$exam->no_question_per_page)}}"
                                name="no_question_per_page" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>                                                                                                                               
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group row">
                            <label>{{ trans('learning::local.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="5">{{old('description',$exam->description)}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('exams.index')}}';">
                    <i class="ft-x"></i> {{ trans('admin.cancel') }}
                  </button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
