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

<h4 class="center">{{ trans('student::local.name_list_sibling') }}</h4>
<h6  style="direction: {{session('lang') == 'ar' ? 'rtl' :'ltr'}}">{{ trans('student::local.siblings_tips',['year'=>fullAcademicYear()]) }}</h6>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' :'ltr'}}">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('student::local.student_number') }}</th>
            <th>{{ trans('student::local.student_name') }}</th>            
            <th>{{ trans('student::local.classroom') }}</th>
            <th>{{ trans('student::local.grade') }}</th>
            <th>{{ trans('student::local.division') }}</th>
        </tr>
    </thead>
    <tbody>
        {{$n=1}}
        @foreach ($students as $stu)
            <tr>
                <td>{{$n}}</td>
                <td>{{ $stu->student->student_number}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        {{ $stu->student->ar_student_name}} {{ $stu->student->father->ar_st_name}} {{ $stu->student->father->ar_nd_name}}
                        {{ $stu->student->father->ar_rd_name}}
                    @else
                        {{ $stu->student->en_student_name}} {{ $stu->student->father->en_st_name}} {{ $stu->student->father->en_nd_name}}
                        {{ $stu->student->father->en_rd_name}}                        
                    @endif
                </td>                
                <td>
                    @if (!empty($stu->classroom_id))
                    {{getClassroomName($stu->classroom_id)}}
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{ $stu->student->grade->ar_grade_name}}
                    @else
                        {{ $stu->student->grade->en_grade_name}}
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{ $stu->student->division->ar_division_name}}
                    @else
                        {{ $stu->student->division->en_division_name}}
                    @endif
                </td>                
            </tr>
            {{$n++}}
        @endforeach
    </tbody>
</table>

@include('layouts.backEnd.layout-report.footer')