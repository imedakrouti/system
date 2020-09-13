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
            <li class="breadcrumb-item"><a href="{{route('parents.index')}}">{{ trans('student::local.parents') }}</a></li>
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
              <div class="col-md-12">
                  <h2 class="mb-2">{{$mother->full_name}}</h2>
              </div>
            <div class="col-md-12">                
                <a href="{{route('mothers.addHusband',$id)}}" class="btn btn-secondary white"><i class="la la-female"></i> {{ trans('student::local.add_father') }}</a>                
                <a href="{{route('mothers.edit',$id)}}" class="btn btn-warning white"><i class="la la-edit"></i> {{ trans('student::local.edit_mother_data') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
              <div class="col-md-12">                
                <h5> {{ trans('student::local.mother_main_data') }}</h5>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <h6>{{ trans('student::local.id_type') }} : {{$mother->id_type_m}}</h6>
                    <h6>{{ trans('student::local.religion') }} : 
                      {{$mother->religion_m == 'muslim' ? trans('student::local.muslim_m') : trans('student::local.non_muslim_m')}}</h6>
                    <h6>{{ trans('student::local.job') }} : {{$mother->job_m}}</h6>
                    <h6>{{ trans('student::local.facebook') }} : {{$mother->facebook_m}}</h6>
                  </div>
                  <div class="col-md-6">
                    <h6>{{ trans('student::local.id_number') }} : {{$mother->id_number_m}}</h6>
                    <h6>{{ trans('student::local.nationality_id') }} : {{$mother->nationalities->ar_name_nat_female}}</h6>
                    <h6>{{ trans('student::local.qualification') }} : {{$mother->qualification_m}}</h6>
                    <h6>{{ trans('student::local.whatsapp_number') }} : {{$mother->whatsapp_number_m}}</h6>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
              <div class="col-md-12">                
                <h5> {{ trans('student::local.contacts_data') }}</h5>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <h6>{{ trans('student::local.home_phone') }} : {{$mother->home_phone_m}}</h6>
                    <h6>{{ trans('student::local.mobile1') }} : {{$mother->mobile1_m}}</h6>
                    <h6>{{ trans('student::local.block_no') }} : {{$mother->block_no_m}}</h6>
                    <h6>{{ trans('student::local.state') }} : {{$mother->state_m}}</h6>
                  </div>
                  <div class="col-md-6">
                    <h6>{{ trans('student::local.email') }} : {{$mother->email_m}}</h6>
                    <h6>{{ trans('student::local.mobile2') }} : {{$mother->mobile2_m}}</h6>
                    <h6>{{ trans('student::local.street_name') }} : {{$mother->street_name_m}}</h6>
                    <h6>{{ trans('student::local.government') }} : {{$mother->government_m}}</h6>
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
  <div class="col-md-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <h4 class="center blue"> {{ trans('student::local.sons') }}</h4>                
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>{{ trans('student::local.student_number') }}</th>
                  <th>{{ trans('student::local.student_name') }}</th>
                  <th>{{ trans('student::local.father_name') }}</th>
                  <th>{{ trans('student::local.registration_status') }}</th>
                  <th>{{ trans('student::local.grade') }}</th>
                  <th>{{ trans('student::local.division') }}</th>                  
                </tr>
              </thead>
              <tbody>
                @foreach ($mother->fathers as $father)
                    @foreach ($father->students as $student)                    
                      @if ($mother->id == $student->mother_id)
                        <tr>
                            {{-- stuednt number --}}
                            <td>{{$student->student_number}}</td>
                            {{-- student name --}}
                            <td>
                              <a href="{{route('students.show',$student->id)}}">{{session('lang') == 'ar' ? $student->ar_student_name : $student->en_student_name}}</a>
                            </td>
                            {{-- father name --}}
                            <td>
                              {{-- {{dd($student->father->id)}} --}}
                                  {{-- father name --}}
                                  @if (session('lang')=='ar')
                                    <a href="{{route('father.show',$student->father->id)}}">{{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}</a>
                                  @else
                                    <a href="{{route('father.show',$student->father->id)}}">{{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}</a>
                                  @endif                                                                  
                            </td>
                            {{-- status --}}
                            <td>
                                {{session('lang') == 'ar'?$student->regStatus->ar_name_status:$student->regStatus->en_name_status }}
                            </td>
                            {{-- grade --}}
                            <td>
                              {{session('lang') == 'ar'?$student->grade->ar_grade_name:$student->grade->en_grade_name }}
                            </td>
                            {{-- division --}}
                            <td>
                              {{session('lang') == 'ar'?$student->division->ar_division_name:$student->division->en_division_name }}
                            </td>                         
                        </tr>
                      @endif
                    @endforeach
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