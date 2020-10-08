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
    <h4 class="center">{{ trans('student::local.student_reports') }} </h4>
</htmlpageheader> 

<h4>{{ trans('student::local.report_title') }} : {{$report->report_title}}</h4>

<h4>{{ trans('student::local.student_name') }} :         
    @if (session('lang') == 'ar')
    {{$report->students->ar_student_name}} {{$report->students->father->ar_st_name}} {{$report->students->father->ar_nd_name}} {{$report->students->father->ar_rd_name}} {{$report->students->father->ar_th_name}}
    @else
    {{$report->students->en_student_name}} {{$report->students->father->en_st_name}} {{$report->students->father->en_nd_name}} {{$report->students->father->en_rd_name}} {{$report->students->father->en_th_name}}
    @endif   
</h4>
<h4><u>{{ trans('student::local.siblings') }}</u></h4>
<ol>
    @foreach ($mothers as $mother)
        @foreach ($mother->students as $student)
            @if ($student->id <> $report->students->id)
                <li>{{$student->ar_student_name}} [ {{$mother->full_name}} ]</li>
            @endif
        @endforeach                
    @endforeach        
</ol>


<hr>

<p style="text-align: justify">{{$report->report}}</p>

<htmlpagefooter name="page-footer">
    <p> {PAGENO}</p>
    </htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')