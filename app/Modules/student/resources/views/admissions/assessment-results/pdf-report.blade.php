@include('layouts.backEnd.layout-report.header')
@include('student::_includes._header-admission')

<h4 class="center">{{ trans('student::local.assessment_results') }}</h4>
<div class="mb-5">
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 200px">{{ trans('student::local.assessmentDate') }}</th>
                <td>{{$assessment->created_at}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.student_name') }}</th>
                <td>
                    @if (session('lang') == 'ar')
                    {{$assessment->students->ar_student_name}} 
                      {{$assessment->students->father->ar_st_name}} {{$assessment->students->father->ar_nd_name}} 
                      {{$assessment->students->father->ar_rd_name}}
                    @else
                    {{$assessment->students->en_student_name}} 
                      {{$assessment->students->father->en_st_name}} {{$assessment->students->father->en_nd_name}} 
                      {{$assessment->students->father->en_rd_name}} 
                    @endif
                </td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.grade') }}</th>
                <td>
                    {{session('lang') == 'ar' ?$assessment->students->grade->ar_grade_name:$assessment->student->grade->en_grade_name}}
                </td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.division') }}</th>
                <td>
                    {{session('lang') == 'ar' ?$assessment->students->division->ar_division_name:$assessment->students->division->en_division_name}}
                </td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.assessment_type') }}</th>
                <td>{{$assessment->assessment_type}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.application_date') }}</th>
                <td>{{$assessment->students->application_date}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.acceptance') }}</th>
                <td>{{$assessment->acceptance}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.notes') }}</th>
                <td>{{$assessment->notes}}</td>
            </tr>
        </thead>
    </table>
</div>
{{ trans('student::local.assessment_results') }}
<table>
    <thead>                        
      <th class="center">{{ trans('student::local.subject_name') }}</th>
      <th class="center">{{ trans('student::local.evaluation') }}</th>
      <th class="center">{{ trans('student::local.teacher_name') }}</th>
    </thead>
    <tbody>
      @foreach ($assessment->tests as $test)
        <tr>                                                        
          <td class="center">{{session('lang') == 'ar' ?$test->acceptTest->ar_test_name : $test->acceptTest->en_test_name}}</td>
          <td class="center">{{$test->test_result}}</td>
          <td class="center">{{$test->employee->arEmployeeName}}</td>
        </tr>                                                
      @endforeach                      
    </tbody>
  </table>
@include('layouts.backEnd.layout-report.footer')