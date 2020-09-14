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
          {{$students->links()}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
 
    </script>
@endsection

 