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
    <h4 class="center">{{ trans('student::local.school_statement') }} 
        {{$statements[0]->grade->ar_grade_name}} - 
        {{ trans('student::local.year') }}
        {{$statements[0]->year->name}}
    </h4>
</htmlpageheader>

<table style="direction: {{session('lang') == 'ar' ? 'rtl' : 'ltr'}}">
    <thead>
        <tr>
            <th width="20" rowspan="2">{{ trans('student::local.serial') }}</th>
            <th width="200" rowspan="2">{{ trans('student::local.student_name') }}</th>
            <th width="50" rowspan="2">{{ trans('student::local.type') }}</th>
            <th width="50" rowspan="2">{{ trans('student::local.religion') }}</th>
            <th width="60" rowspan="2">{{ trans('student::local.register_status_id') }}</th>
            <th width="60" rowspan="2">{{ trans('student::local.nationality_id') }}</th>
            <th width="60" colspan="3">{{ trans('student::local.dob') }}</th>
            <th width="60" colspan="3">{{ trans('student::local.dob_in_october') }}</th>
            <th width="120" rowspan="2">{{ trans('student::local.student_id_number') }}</th>            
            <th width="200" rowspan="2">{{ trans('student::local.the_address') }}</th>
        </tr>
        <tr>            
            <th>{{ trans('student::local.dd') }}</th>
            <th>{{ trans('student::local.mm') }}</th>
            <th>{{ trans('student::local.yy') }}</th>  
            <th>{{ trans('student::local.dd') }}</th>
            <th>{{ trans('student::local.mm') }}</th>
            <th>{{ trans('student::local.yy') }}</th>                        
        </tr>
    </thead>
    <tbody>
        {{$i = 1}}
        @foreach ($statements as $statement)
            <tr>
                <td>{{$i}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$statement->student->ar_student_name}}
                        {{$statement->student->father->ar_st_name}}
                        {{$statement->student->father->ar_nd_name}}
                        {{$statement->student->father->ar_rd_name}}
                    @else
                        {{$statement->student->en_student_name}}
                        {{$statement->student->father->en_st_name}}
                        {{$statement->student->father->en_nd_name}}
                        {{$statement->student->father->en_rd_name}}
                    @endif
                </td>
                <td>{{$statement->student->gender}}</td>
                <td>{{$statement->student->religion}}</td>
                <td>{{$statement->regStatus->ar_name_status}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        @if ($statement->student->gender == trans('student::local.male'))
                            {{$statement->student->nationalities->ar_name_nat_male}}
                        @else
                            {{$statement->student->nationalities->ar_name_nat_female}}
                        @endif
                    @else
                    {{$statement->student->nationalities->en_name_nationality}}
                    @endif
                </td>
                {{-- <td>{{$statement->student->dob}}</td> --}}
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $statement->student->dob)->day}}</td>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $statement->student->dob)->month}}</td>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $statement->student->dob)->year}}</td>
                <td>{{$statement->dd}}</td>
                <td>{{$statement->mm}}</td>
                <td>{{$statement->yy}}</td>
                <td>{{$statement->student->student_id_number}}</td>                
                <td>{{$statement->student->father->street_name}}</td>
            </tr>
            {{$i++}}
        @endforeach
    </tbody>
</table>
<br>
<table style="margin-right: 75%;direction: {{session('lang') == 'ar' ? 'rtl' : 'ltr'}}">
    <thead>
        <tr>
            <th colspan="3">{{ trans('student::local.boy') }}</th>
            <th colspan="3">{{ trans('student::local.girl') }}</th>
            <th rowspan="2">{{ trans('student::local.totalStudents') }}</th>
        </tr>
        <tr>
            <th>{{ trans('student::local.muslim') }}</th>
            <th>{{ trans('student::local.non_muslim') }}</th>
            <th>{{ trans('student::local.totalStudents') }}</th>
            <th>{{ trans('student::local.muslim') }}</th>
            <th>{{ trans('student::local.non_muslim') }}</th>
            <th>{{ trans('student::local.totalStudents') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$male_muslims[0]}}</td>
            <td>{{$male_non_muslims[0]}}</td>
            <td><strong>{{$male_muslims[0] + $male_non_muslims[0]}}</strong></td>
            <td>{{$female_muslims[0]}}</td>
            <td>{{$female_non_muslims[0]}}</td>
            <td><strong>{{$female_muslims[0] + $female_non_muslims[0]}}</strong></td>
            <td>
                <strong>
                    {{$male_muslims[0] + $male_non_muslims[0] + 
                        $female_muslims[0] + $female_non_muslims[0] }}     
                </strong>           
            </td>

        </tr>
    </tbody>
</table>


<htmlpagefooter name="page-footer">
    <div class="signature">        
        {!!$signature!!}
    </div>	
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')