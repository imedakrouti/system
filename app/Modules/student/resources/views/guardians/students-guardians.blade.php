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
            <li class="breadcrumb-item"><a href="{{route('guardians.index')}}">{{ trans('student::local.guardians') }}</a></li>
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-xs-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
                <h3 class="blue">{{$guardian->guardian_full_name}}</h3>
                <h5>{{ trans('student::local.guardian_guardian_type') }} : {{$guardian->guardian_guardian_type}}</h5>
                <h5>{{ trans('student::local.guardian_mobile1') }} : {{$guardian->guardian_mobile1}}</h5>
                <h5>{{ trans('student::local.guardian_mobile2') }} : {{$guardian->guardian_mobile2}}</h5>
                <h5>{{ trans('student::local.guardian_id_type') }} : {{$guardian->guardian_id_type}}</h5>
                <h5>{{ trans('student::local.guardian_id_number') }} : {{$guardian->guardian_id_number}}</h5>
                
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="card">
          <div class="card-content collapse show">
            <div class="card-body">
                <h5>{{ trans('student::local.guardian_email') }} : {{$guardian->guardian_email}}</h5>
                <h5>{{ trans('student::local.guardian_job') }} : {{$guardian->guardian_job}}</h5>
                <h5>{{ trans('student::local.guardian_block_no') }} : {{$guardian->guardian_block_no}}</h5>
                <h5>{{ trans('student::local.guardian_street_name') }} : {{$guardian->guardian_street_name}}</h5>
                <h5>{{ trans('student::local.guardian_state') }} : {{$guardian->guardian_state}}</h5>
                <h5>{{ trans('student::local.guardian_government') }} : {{$guardian->guardian_government}}</h5>
  
            </div>
          </div>
        </div>
      </div>
  </div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">          
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>{{ trans('student::local.student_number') }}</th>
                  <th>{{ trans('student::local.student_name') }}</th>
                  <th>{{ trans('student::local.registration_status') }}</th>
                  <th>{{ trans('student::local.grade') }}</th>
                  <th>{{ trans('student::local.division') }}</th>
                  <th>{{ trans('student::local.mother_name') }}</th>                  
                </tr>
              </thead>
              <tbody>
                  
                @foreach ($students as $student)
                  <tr>
                    <td>
                      {{$student->student_number}}
                    </td>
                    <td>
                      <a href="{{route('students.show',$student->id)}}">{{session('lang') == 'ar'?$student->ar_student_name:$student->en_student_name }}</a>
                    </td>
                    <td>
                      {{session('lang') == 'ar'?$student->regStatus->ar_name_status:$student->regStatus->en_name_status }}
                    </td>
                    <td>
                      {{session('lang') == 'ar'?$student->grade->ar_grade_name:$student->grade->en_grade_name }}
                    </td>
                    <td>
                      {{session('lang') == 'ar'?$student->division->ar_division_name:$student->division->en_division_name }}
                    </td>
                    <td>
                      <a href="{{route('mother.show',$student->mother_id)}}">{{$student->mother->full_name}}</a>
                    </td>
                  </tr>
                @endforeach                  
              </tbody>
            </table>  
          </div>         
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
