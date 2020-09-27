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
    
</htmlpageheader>
<h3 class="center">{{ trans('student::local.endorsement_leave_request') }}</h3>
<p class="paragraph">{{$content}}</ style="font-size: ">


@include('layouts.backEnd.layout-report.footer')