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
    <h4 class="center">{{ trans('student::local.student_commissioner_deliver') }} </h4>
</htmlpageheader>
<p>
    @php
        $student_name = '';
        if (session('lang') == 'ar') {
            $student_name = $student->ar_student_name .' '.
            $student->father->ar_st_name.' '. $student->father->ar_nd_name.' '. $student->father->ar_rd_name;
        }
        else{
            $student_name = $student->en_student_name .' '.
            $student->father->en_st_name.' '. $student->father->en_nd_name.' '. $student->father->en_rd_name;
        }
    @endphp
    {{ trans('student::local.father_allow_commissioner',
    [
        'studentName'   => $student_name,
        'idNumber'      => $student->father->id_number
    ]) }}
</p>
<table>
    <thead>
        <tr>
            <th>{{ trans('student::local.commissioner_name') }}</th>
            <th>{{ trans('student::local.id_number_card') }}</th>
            <th>{{ trans('student::local.mobile_number') }}</th>            
            <th>{{ trans('student::local.relation') }}</th>            
        </tr>
    </thead>
    <tbody>
        @foreach ($commissioners as $commissioner)
            <tr>
                <td>{{$commissioner->commissioner_name}}</td>
                <td>{{$commissioner->id_number}}</td>
                <td>{{$commissioner->mobile}}</td>
                <td>{{$commissioner->relation}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="signature">
    <br>
        <h4 class="center"><strong>{{ trans('student::local.father_sign') }}</strong>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>{{ trans('student::local.mother_sign') }}</strong>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>{{ trans('admin.students_affairs') }}</strong></h4>
</div>	
<htmlpagefooter name="page-footer">
   <p> {PAGENO}</p>
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')