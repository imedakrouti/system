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

<h4 class="center">{{ trans('student::local.name_list') }} [{{$classroom}}]</h4>
<h5>{{ trans('student::local.second_lang_id') }} : {{$language}}</h5>
<table style="direction: {{session('lang') == 'ar' ? 'rtl' :'ltr'}}">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('student::local.student_number') }}</th>
            <th>{{ trans('student::local.student_name') }}</th>
            <th>{{ trans('student::local.register_status_id') }}</th>
            <th>{{ trans('student::local.religion') }}</th>            
            <th>{{ trans('student::local.nationality_id') }}</th>
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
                        {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}}
                        {{$student->father->ar_rd_name}}
                    @else
                        {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}}
                        {{$student->father->en_rd_name}}                        
                    @endif
                </td>
                <td>{{$student->regStatus->ar_name_status}}</td>
                <td>{{$student->religion}}</td>                
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

@include('layouts.backEnd.layout-report.footer')