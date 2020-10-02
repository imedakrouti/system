@include('layouts.backEnd.layout-report.header')
<div class="right-header" style="margin-top: 10px">
    <img src="{{$logo}}" alt="" class="logo">
</div>
<div class="center-header">
    {{ trans('student::local.admission_department') }} <br>
    {{$schoolName}} 
    <h4 class="center">{{ trans('student::local.application_reprot') }}</h4>
</div>
<div class="left-header">
    <div class="photo">
        <img src="{{$studentPathImage}}">
    </div>
</div>
<div class="clear"></div>
<hr>
{{ trans('student::local.student_data') }}
<div style="border: 1px solid #333; padding:5px;">    
    {{ trans('student::local.student_name') }} : 
    @if (session('lang') == 'ar')
        {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}
    @else
        {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}
    @endif
</div>
@include('layouts.backEnd.layout-report.footer')