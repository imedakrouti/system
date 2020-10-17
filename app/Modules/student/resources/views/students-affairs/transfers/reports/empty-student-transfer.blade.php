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

<div style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">
    {{-- student data --}}
    <h4 class="small-weight" style="width:50%;float: right"><strong>{{ trans('student::local.student_name') }} :  </strong>           
         ......................................................
    </h4>
    <h4 class="small-weight" ><strong>{{ trans('student::local.current_school') }} :</strong> .........................................    
    </h4>
    
    <h4 class="small-weight"><strong>{{ trans('student::local.grade') }} : </strong> ................................................. </h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.dob') }} :</strong> ..................................................... </h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.trasfer_school') }} :</strong> ............................................................................. </h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.the_address') }} :</strong> 
        ..................................................................................................................
    </h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.leave_reason') }} :</strong> ....................................................</h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.school_fees') }} :</strong> ....................................................</h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.school_books') }} :</strong> ....................................................</h4>
    
    <h4 class="small-weight" style="width:60%;float: right"><strong>{{ trans('student::local.student_father_name') }} / 
        {{ trans('student::local.guardian') }}:</strong>...............................</h4>
    <h4 class="small-weight"><strong>{{ trans('student::local.signature') }} :</strong>...............................</h4>

</div>
<hr>
<div style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">
    {{-- other school data --}}
    <h4 class="small-weight"><strong>{{ trans('student::local.school_manager') }} :</strong>
        ................................................................................................</h4>
    <h4 class="small-weight" style="padding-right: 50px">{{ trans('student::local.greetings') }}</h4>
    <h4 class="small-weight" style="padding-right: 20px">{{ trans('student::local.please_tell_us') }}</h4>
    <h4 class="small-weight" style="padding-right: 200px">{{ trans('student::local.thanks_respect') }}</h4>
    <h4 class="small-weight" style="width:60%;float: right"><strong>
        {{ trans('student::local.date') }}:</strong>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;/</h4>
    <h4 class="small-weight" style="padding-right: 200px"><strong>{{ trans('student::local.principal') }}</strong></h4>
</div>

<hr>
<div style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">
    {{-- receipt --}}
    <h4 class="center">{{ trans('student::local.receipt') }}</h4>
    <h4 class="small-weight" style="text-align: justify;line-height: 2">{{ trans('student::local.receipt_content') }}</h4>
</div>
<h4 class="small-weight" style="padding-right: 450px"><strong>{{ trans('student::local.sign_employee') }}</strong></h4>

@include('layouts.backEnd.layout-report.footer')