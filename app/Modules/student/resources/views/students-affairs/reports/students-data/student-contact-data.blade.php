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

<h4 class="center">{{ trans('student::local.student_contacts_data') }} [{{$classroom}}]</h4>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' : 'ltr'}}">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('student::local.student_number') }}</th>
            <th>{{ trans('student::local.student_name') }}</th>
            <th>{{ trans('student::local.father_mobile1') }}</th>
            <th>{{ trans('student::local.father_mobile2') }}</th>
            <th>{{ trans('student::local.mother_mobile1') }}</th>
            <th>{{ trans('student::local.mother_mobile2') }}</th>
        </tr>
    </thead>
    <tbody>
        {{$n=1}}
        @foreach ($students as $student)
            <tr>
                <td>{{$n}}</td>
                <td>{{$student->student_number}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$student->ar_student_name}} {{$student->father->ar_st_name}}  
                        {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}       
                    @else
                        {{$student->en_student_name}} {{$student->father->en_st_name}}  
                        {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}                                    
                    @endif  
                </td>
                <td>{{$student->father->mobile1}}</td>
                <td>{{$student->father->mobile2}}</td>
                <td>{{$student->mother->mobile1_m}}</td>
                <td>{{$student->mother->mobile2_m}}</td>
            </tr>
            {{$n++}}
        @endforeach
    </tbody>
</table>

@include('layouts.backEnd.layout-report.footer')