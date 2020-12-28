@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}} | {{$class_name}}</h3>  
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
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
            <form action="{{route('behaviour.store')}}" method="post">    
                <div class="row">    
                    <input type="hidden" name="year_id" value="{{currentYear()}}">                       
                    <input type="hidden" name="classroom_id" value="{{$classroom_id}}">                       
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>{{ trans('learning::local.month') }}</label>
                            <select name="month_id" class="form-control" required>
                                <option value="">{{ trans('staff::local.select') }}</option>
                                @foreach ($months as $month)
                                    <option value="{{$month->id}}">{{$month->month_name}}</option>
                                @endforeach
                            </select>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('learning::local.subject') }}</label>
                          <select name="subject_id" class="form-control" required>                                
                              @foreach (employeeSubjects() as $subject)
                                  <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                      {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                                                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>{{ trans('learning::local.total_mark') }}</label>
                            <input type="text" readonly value="10" class="form-control">                            
                        </div>
                    </div>
                </div>
                @csrf
                <div class="table-responsive">
                    <table class="table" id="dynamic-table">
                      <thead>
                        <tr class="center">
                          <th>{{ trans('learning::local.student_name') }}</th>
                          <th>{{ trans('learning::local.mark') }}</th>              
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td with="90%">
                                    <input type="hidden" name="student_id[]" value="{{$student->id}}">
                                    {{$student->student_name}}
                                </td>
                                <td width="10%" class="center">
                                    <input type="number" min="0" max="10" value="0" step="1" name="behaviour_mark[]" class="form-control">
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('behaviour.index')}}';">
                    <i class="ft-x"></i> {{ trans('admin.cancel') }}
                  </button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection