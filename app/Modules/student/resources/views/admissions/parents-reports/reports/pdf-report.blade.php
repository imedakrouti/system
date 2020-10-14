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
    <h4 class="center">{{ trans('student::local.parent_reports') }} </h4>
</htmlpageheader>  

    <h4>{{ trans('student::local.report_title') }} : {{$reports->report_title}}</h4>

    <h4>{{ trans('student::local.parent_name') }} :      
        @if (session('lang') == 'ar')
            {{$reports->fathers['ar_st_name']}} {{$reports->fathers['ar_nd_name']}} {{$reports->fathers['ar_rd_name']}} {{$reports->fathers['ar_th_name']}}
        @else
            {{$reports->fathers['en_st_name']}} {{$reports->fathers['en_nd_name']}} {{$reports->fathers['en_rd_name']}} {{$reports->fathers['en_th_name']}}
        @endif   
    </h4> 
    <h4><u>{{ trans('student::local.sons') }}</u></h4>
    <ol>
        @foreach ($mothers as $mother)
            @foreach ($mother->students as $student)
            <li>{{$student->ar_student_name}} [ {{$mother->full_name}} ]</li>
            @endforeach                
        @endforeach        
    </ol>

    <hr>
    <p style="text-align: justify">{{$reports->report}}</p>
<htmlpagefooter name="page-footer">
    <p> {PAGENO}</p>
    </htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')