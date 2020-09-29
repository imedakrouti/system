@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 
    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="right-header">
        {{$governorate}} <br>
        {{$education_administration}} <br>  

    </div>
    <div class="clear"></div>    
</htmlpageheader>
<h3 class="center">{{ trans('student::local.student_request_transfer') }}</h3>

{{-- student data --}}
<h4 class="small-weight" style="width:50%;float: right"><strong>{{ trans('student::local.student_name') }} :  </strong>           
     @if (session('lang') == 'ar')
        {{$transfer->students->ar_student_name}} {{$transfer->students->father->ar_st_name}} {{$transfer->students->father->ar_nd_name}}
        {{$transfer->students->father->ar_rd_name}}
    @else
        {{$transfer->students->en_student_name}} {{$transfer->students->father->en_st_name}} {{$transfer->students->father->en_nd_name}}
        {{$transfer->students->father->en_rd_name}}                        
    @endif
</h4>
<h4 class="small-weight" ><strong>{{ trans('student::local.current_school') }} :</strong>{{$school_name}}     
</h4>

<h4 class="small-weight"><strong>{{ trans('student::local.grade') }} : </strong>{{$transfer->currentGrade->ar_grade_name}}</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.dob') }} :</strong> {{$transfer->students->dob}}</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.trasfer_school') }} :</strong> {{$transfer->schools->school_name}}</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.the_address') }} :</strong> 
    {{$transfer->students->father->block_no}} - {{$transfer->students->father->street_name}} - 
    {{$transfer->students->father->government}}
</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.leave_reason') }} :</strong> {{$transfer->leave_reason}}</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.school_fees') }} :</strong> {{$transfer->school_fees}}</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.school_books') }} :</strong> {{$transfer->school_books}}</h4>

<h4 class="small-weight" style="width:60%;float: right"><strong>{{ trans('student::local.student_father_name') }} / 
    {{ trans('student::local.guardian') }}:</strong>...............................</h4>
<h4 class="small-weight"><strong>{{ trans('student::local.signature') }} :</strong>...............................</h4>
<hr>

{{-- other school data --}}
<h4 class="small-weight"><strong>{{ trans('student::local.school_manager') }} :</strong>
    ................................................................................................</h4>
<h4 class="small-weight" style="padding-right: 50px">{{ trans('student::local.greetings') }}</h4>
<h4 class="small-weight" style="padding-right: 20px">{{ trans('student::local.please_tell_us') }}</h4>
<h4 class="small-weight" style="padding-right: 200px">{{ trans('student::local.thanks_respect') }}</h4>
<h4 class="small-weight" style="width:60%;float: right"><strong>
    {{ trans('student::local.date') }}:</strong>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;/</h4>
<h4 class="small-weight" style="padding-right: 200px"><strong>{{ trans('student::local.principal') }}</strong></h4>
<br>
<hr>
{{-- receipt --}}
<h4 class="center">{{ trans('student::local.receipt') }}</h4>
<h4 class="small-weight" style="text-align: justify;line-height: 2">{{ trans('student::local.receipt_content') }}</h4>
<h4 class="small-weight" style="padding-right: 450px"><strong>{{ trans('student::local.sign_employee') }}</strong></h4>

@include('layouts.backEnd.layout-report.footer')