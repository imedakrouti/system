@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header">
    <div class="left-header" style="margin-top: -25px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="right-header">
        {{ trans('student::local.goverment') }} <br>
        {{ trans('student::local.management') }} <br>
        {{$schoolName}}     
    </div>
    <div class="clear"></div>
    <hr>
    <h4 class="center">{{ trans('student::local.school_statement') }}</h4>
</htmlpageheader>

<table>
    <thead>
        <tr>
            <th rowspan="2">{{ trans('student::local.serial') }}</th>
            <th rowspan="2">{{ trans('student::local.student_name') }}</th>
            <th rowspan="2">{{ trans('student::local.gender') }}</th>
            <th rowspan="2">{{ trans('student::local.religion') }}</th>
            <th rowspan="2">{{ trans('student::local.register_status_id') }}</th>
            <th rowspan="2">{{ trans('student::local.dob') }}</th>
            <th colspan="3">{{ trans('student::local.dob_in_october') }}</th>
            <th rowspan="2">{{ trans('student::local.student_id_number') }}</th>
            <th rowspan="2">{{ trans('student::local.father_mobile') }}</th>
            <th rowspan="2">{{ trans('student::local.the_address') }}</th>
        </tr>
        <tr>            
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
                <td>{{$statement->student->ar_student_name}}</td>
                <td>{{$statement->student->gender}}</td>
                <td>{{$statement->student->religion}}</td>
                <td>{{$statement->regStatus->ar_name_status}}</td>
                <td>{{$statement->student->dob}}</td>
                <td>{{$statement->dd}}</td>
                <td>{{$statement->mm}}</td>
                <td>{{$statement->yy}}</td>
                <td>{{$statement->student->student_id_number}}</td>
                <td>{{$statement->student->father->mobile1}}</td>
                <td>{{$statement->student->father->street_name}}</td>
            </tr>
            {{$i++}}
        @endforeach
    </tbody>
</table>


<htmlpagefooter name="page-footer">
    <div class="signature">
        <h3 style="text-align: left; margin-left:80px;"><strong>{{ trans('admin.students_affairs') }}</strong></h3>
    </div>	
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')