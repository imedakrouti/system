@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">      
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>            
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
{{-- Statistics --}}
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-warning">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['applicants']}}</h3>
                <span>{{ trans('student::local.all_applicants') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-child text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-success">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['students']}}</h3>
                <span>{{ trans('student::local.all_students') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-graduation-cap text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-danger">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['parents']}}</h3>
                <span>{{ trans('student::local.parents') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-users text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-info">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['guardians']}}</h3>
                <span>{{ trans('student::local.guardians') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-male text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div id="recent-sales" class="col-12 col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title"><a href="{{route('applicants-counts.divisions')}}">{{ trans('student::local.statistic') }}</a></h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-content mt-1">
        <div class="table-responsive">
          <table id="recent-orders" class="table table-hover table-xl mb-0">
            <thead>
              <tr>
                <th class="border-top-0">{{ trans('student::local.grades') }}</th>
                <th class="border-top-0">{{ trans('student::local.applicants_count') }}</th>                        
              </tr>
            </thead>
            <tbody>
              @foreach ($gradeCounts as $count)
                  <tr>
                    <td>{{$count->ar_grade_name}}</td>
                    <td>{{$count->applicants}}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-8">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title"><a href="{{route('applicants.today')}}">{{ trans('student::local.today_applicants') }}</a></h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-content mt-1">
        <div class="table-responsive">
          <table id="recent-orders" class="table table-hover table-xl mb-0">
            <thead>
              <tr>
                <th class="border-top-0">{{ trans('student::local.applicants_name') }}</th>
                <th class="border-top-0">{{ trans('student::local.grade') }}</th>
                <th class="border-top-0">{{ trans('student::local.division') }}</th>                            
                <th class="border-top-0">{{ trans('student::local.mother_name') }}</th>                            
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $student)
                  <tr>
                    <td>
                      <a href="{{route('students.show',$student->id)}}">
                        @if (session('lang') == 'ar')
                          {{$student->ar_student_name}}
                          {{$student->father->ar_st_name}}
                          {{$student->father->ar_nd_name}}                          
                          {{$student->father->ar_rd_name}}                          
                          {{$student->father->ar_th_name}}                          
                        @else
                          {{$student->en_student_name}}
                          {{$student->father->en_st_name}}
                          {{$student->father->ar_nd_name}}                          
                          {{$student->father->ar_rd_name}}                          
                          {{$student->father->en_th_name}}                                                 
                        @endif
                      </a>
                    </td>
                    <td>
                      {{session('lang') == 'ar' ? $student->grade->ar_grade_name : $student->grade->en_grade_name}}
                    </td>
                    <td>
                      {{session('lang') == 'ar' ? $student->division->ar_division_name : $student->division->en_division_name}}
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

@endsection
@section('script')

@endsection