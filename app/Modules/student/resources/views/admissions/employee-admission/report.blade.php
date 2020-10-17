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
    <h4 class="center">{{ trans('student::local.emp_open_admission_report') }} </h4>
</htmlpageheader> 

<h5 style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">{{ trans('student::local.employee_name') }} : {{$employeeName}} <br>
{{ trans('student::local.period') }}
{{ trans('student::local.from') }} : {{$fromDate}} {{ trans('student::local.to') }} : {{$toDate}} <br>
{{ trans('student::local.admission_count') }} : {{$count}}</h5>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' : 'ltr'}}">
    <thead>
        <tr>
            <th>{{ trans('student::local.application_date') }}</th>
            <th>{{ trans('student::local.student_name') }}</th>
            <th>{{ trans('student::local.grade') }}</th>
            <th>{{ trans('student::local.division') }}</th>    
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{$student->application_date}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$student->ar_student_name}} 
                        {{$student->father->ar_st_name}} 
                        {{$student->father->ar_nd_name}} 
                        {{$student->father->ar_rd_name}} 
                    @else
                        {{$student->en_student_name}} 
                        {{$student->father->en_st_name}} 
                        {{$student->father->en_nd_name}} 
                        {{$student->father->en_rd_name}}                         
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$student->grade->ar_grade_name}}
                    @else
                        {{$student->grade->en_grade_name}}  
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$student->division->ar_division_name}}
                    @else
                        {{$student->division->en_division_name}}  
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<hr>
<p class="report-details"  style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">{{ trans('admin.print_date') }} : {{now()}} <br>
{{ trans('admin.username') }} : {{authInfo()->username}}</p>

@include('layouts.backEnd.layout-report.footer')