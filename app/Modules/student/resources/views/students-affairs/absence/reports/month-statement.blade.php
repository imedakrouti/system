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
    <h4 class="center">{{$classroom}}</h4>
    <h4 class="center">{{ trans('student::local.absence_statement') }}  
        {{ trans('student::local.from') }} {{\DateTime::createFromFormat("Y-m-d",request('from_date'))->format("Y/m/d")}}
        {{ trans('student::local.to') }} {{\DateTime::createFromFormat("Y-m-d",request('to_date'))->format("Y/m/d")}}
    </h4>
</htmlpageheader>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' : 'ltr'}}">
    <thead>
        <tr>
            <th rowspan="2">{{ trans('student::local.student_name') }}</th>
            <th colspan="{{count($days)}}">{{ trans('student::local.days') }}</th>
        </tr>
        <tr>
            @foreach ($days as $day)
                <th>{{$day}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)        
            <tr>
                <td style="width: 150px">
                    @if (session('lang') == 'ar')
                        {{$student->ar_student_name}} {{$student->father->ar_st_name}} 
                        {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}
                    @else
                        {{$student->en_student_name}} {{$student->father->en_st_name}} 
                        {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}
                    @endif
                </td>
                @foreach ($days as $day)
                    {{$status = false}}
                    @foreach ($absences as $absence)
                        @if ( $absence->student_id == $student->id)
                            {{$date = \Carbon\Carbon::createFromFormat('Y-m-d', $absence->absence_date)->day}}
                            @if ($day == $date)
                                {{$status = true}}
                            @endif                               
                        @endif
                    @endforeach
                    @if ($status)
                        @if (session('lang') == 'ar')
                            <td>غـ</td>
                        @else
                            <td>a</td> 
                        @endif
                    @else
                        <td></td>
                    @endif                    
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<htmlpagefooter name="page-footer">
 
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')