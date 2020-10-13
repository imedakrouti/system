@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header">
    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="right-header">
        {{$governorate}} <br>
        {{$education_administration}} <br>  
        {{$school_name}}     
    </div>
    <div class="clear"></div>
    <hr>
    <h4 class="center">{{ trans('student::local.assessment_results') }} </h4>
</htmlpageheader>

<div class="mb-5">
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 200px">{{ trans('student::local.assessmentDate') }}</th>
                <td class="right">{{$assessment->created_at}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.student_name') }}</th>
                <td class="right">
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
                <td class="right">
                    {{session('lang') == 'ar' ?$assessment->students->grade->ar_grade_name:$assessment->students->grade->en_grade_name}}
                </td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.division') }}</th>
                <td class="right">
                    {{session('lang') == 'ar' ?$assessment->students->division->ar_division_name:$assessment->students->division->en_division_name}}
                </td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.assessment_type') }}</th>
                <td class="right">{{$assessment->assessment_type}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.application_date') }}</th>
                <td class="right">{{$assessment->students->application_date}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.acceptance') }}</th>
                <td class="right">{{$assessment->acceptance}}</td>
            </tr>
            <tr>
                <th style="width: 200px">{{ trans('student::local.notes') }}</th>
                <td class="right">{{$assessment->notes}}</td>
            </tr>
        </thead>
    </table>
</div>
{{ trans('student::local.assessment_results') }}
<table>
    <thead>                        
        <tr>
            <th class="center">{{ trans('student::local.subject_name') }}</th>
            <th class="center">{{ trans('student::local.evaluation') }}</th>
            <th class="center">{{ trans('student::local.teacher_name') }}</th>
        </tr>
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
<htmlpagefooter name="page-footer">
    <p> {PAGENO}</p>
 </htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')