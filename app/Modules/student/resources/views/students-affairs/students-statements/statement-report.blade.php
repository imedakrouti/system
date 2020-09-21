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
    <h4 class="center">{{ trans('student::local.school_statement') }}</h4>
</htmlpageheader>

<table>
    <thead>
        <tr>
            <th width="20" rowspan="2">{{ trans('student::local.serial') }}</th>
            <th width="200" rowspan="2">{{ trans('student::local.student_name') }}</th>
            <th width="50" rowspan="2">{{ trans('student::local.type') }}</th>
            <th width="50" rowspan="2">{{ trans('student::local.religion') }}</th>
            <th width="70" rowspan="2">{{ trans('student::local.register_status_id') }}</th>
            <th width="80" rowspan="2">{{ trans('student::local.dob') }}</th>
            <th width="60" colspan="3">{{ trans('student::local.dob_in_october') }}</th>
            <th width="120" rowspan="2">{{ trans('student::local.student_id_number') }}</th>
            <th width="70" rowspan="2">{{ trans('student::local.father_mobile') }}</th>
            <th width="200" rowspan="2">{{ trans('student::local.the_address') }}</th>
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