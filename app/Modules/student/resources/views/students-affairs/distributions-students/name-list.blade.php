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
<h3 class="center">{{$classroom}}</h3>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' :'ltr'}}">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('student::local.student_name') }}</th>
            <th>{{ trans('student::local.register_status_id') }}</th>
            <th>{{ trans('student::local.religion') }}</th>
            <th>{{ trans('student::local.second_lang_id') }}</th>
            <th>{{ trans('student::local.nationality_id') }}</th>
        </tr>
    </thead>
    <tbody>
        {{$n=1}}
        @foreach ($students as $student)
            <tr>
                <td>{{$n}}</td>
                <td>{{$student->ar_student_name}}</td>
                <td>{{$student->regStatus->ar_name_status}}</td>
                <td>{{$student->religion}}</td>
                <td>{{$student->languages->ar_name_lang}}</td>
                <td>
                    @if ($student->gender == trans('student::local.male'))
                    {{$student->nationalities->ar_name_nat_male}}
                    @else
                    {{$student->nationalities->ar_name_nat_female}}
                    @endif
                </td>

            </tr>
            {{$n++}}
        @endforeach
    </tbody>
</table>
<br>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' :'ltr'}}; {{session('lang') == 'ar' ?'margin-right: 75%;':'margin-left: 75%;'}}" >
    <thead>
        <tr>
            <th>{{ trans('student::local.boy') }}</th>
            <th>{{ trans('student::local.girl') }}</th>
            <th>{{ trans('student::local.muslim') }}</th>
            <th>{{ trans('student::local.non_muslim') }}</th>
        </tr>

    </thead>
    <tbody>
        <tr>
            <td>{{$male}}</td>
            <td>{{$female}}</td>
            <td>{{$muslim}}</td>
            <td>{{$non_muslim}}</td>
        </tr>
    </tbody>
</table>


@include('layouts.backEnd.layout-report.footer')