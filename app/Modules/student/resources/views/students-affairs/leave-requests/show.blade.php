@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('leave-requests.index')}}">{{ trans('student::local.leave_requests') }}</a></li>
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
            <div class="row">
                <div class="col-md-12">                
                  <h5> {{ trans('student::local.student_data') }}</h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h4><strong>{{ trans('student::local.student_number') }} :</strong> {{$leave->students->student_number}}</h4>                
                      <h4><strong>{{ trans('student::local.student_name') }} :</strong>
                        @if (session('lang') == 'ar')
                            <a href="{{route('students.show',$leave->students->id)}}">
                                {{$leave->students->ar_student_name}}  {{$leave->students->father->ar_st_name}}
                                {{$leave->students->father->ar_nd_name}} {{$leave->students->father->ar_rd_name}}
                            </a>
                        @else
                            <a href="{{route('students.show',$leave->students->id)}}">
                                {{$leave->students->en_student_name}}  {{$leave->students->father->en_st_name}}
                                {{$leave->students->father->en_nd_name}} {{$leave->students->father->en_rd_name}}                            
                            </a>
                        @endif
                      </h4>
                      <h4><strong>{{ trans('student::local.grade') }} :</strong> {{session('lang') == 'ar' ? 
                      $leave->students->grade->ar_grade_name : $leave->students->grade->en_grade_name}}</h4>
                      <h4><strong>{{ trans('student::local.division') }} : </strong>{{session('lang') == 'ar' ? 
                        $leave->students->division->ar_division_name : $leave->students->division->en_division_name}}</h4>              
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">                
                  <div class="row">
                    <div class="col-md-6">
                      <h4><strong>{{ trans('student::local.parent_type') }} :</strong> {{$leave->parent_type}}</h4>                
                      <h4><strong>{{ trans('student::local.leave_reason') }} :</strong> {{$leave->reason}}</h4>
                      <h4><strong>{{ trans('student::local.notes') }} :</strong> {{$leave->notes}}</h4>                                   
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <h3 class="red"><strong>{{ trans('student::local.print_endorsement') }}</strong></h3>
          <hr>
          <div class="row">
              <div class="col-md-8"> 
                <form class="form form-horizontal" action="{{route('leave-requests.update',$leave->id)}}" method="post">
                  @csrf
                  @method('PUT')
                  <textarea class="form-control" name="endorsement" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('endorsement',$leave->endorsement)}}</textarea>                  
                  <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>    
                      <button type="submit" class="btn btn-success">
                        <i class="la la-save"></i> {{ trans('admin.save_dafault') }}
                      </button>                           
                </div>                  
                </form>               
              </div>
              <div class="col-md-4">
                <table class="table">
                  <thead>
                    <tr>
                      <th>{{ trans('student::local.item') }}</th>
                      <th>{{ trans('student::local.description') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>student_name</td>
                      <td>{{ trans('student::local.student_name') }}</td>
                    </tr>
                    <tr>
                      <td>father_name</td>
                      <td>{{ trans('student::local.father_name') }}</td>
                    </tr>  
                    <tr>
                      <td>father_national_id</td>
                      <td>{{ trans('student::local.father_id_number') }}</td>
                    </tr>  
                    <tr>
                      <td>grade</td>
                      <td>{{ trans('student::local.grade') }}</td>
                    </tr>  
                    <tr>
                      <td>year</td>
                      <td>{{ trans('student::local.year') }}</td>
                    </tr>                                                                            
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('public/cpanel/app-assets/vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('public/cpanel/app-assets/js/scripts/editors/editor-ckeditor.js')}}"></script>    
@endsection
