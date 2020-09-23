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
    <h4 class="center">{{ trans('student::local.commissioner_deliver') }} </h4>
</htmlpageheader>
<p>
    {{ trans('student::local.deliver_allow') }}
</p>
<table>
    <thead>
        <tr>
            <th colspan="2" class="right">{{ trans('student::local.deliver_data') }}</th>
        </tr>
        <tr>
            <th width="150">{{ trans('student::local.name') }}</th><td class="right">{{$commissioner->commissioner_name}}</td>            
        </tr>
        <tr>            
            <th width="150">{{ trans('student::local.id_number_card') }}</th><td class="right">{{$commissioner->id_number}}</td>            
        </tr>
        <tr>                        
            <th width="150">{{ trans('student::local.mobile_number') }}</th><td class="right">{{$commissioner->mobile}}</td>
        </tr>
        <tr>                        
            <th width="150">{{ trans('student::local.relation') }}</th><td class="right">{{$commissioner->relation}}</td>
        </tr>        
        <tr>            
            <th width="150">{{ trans('student::local.notes') }}</th><td class="right">{{$commissioner->notes}}</td>                        
        </tr>
    </thead>
</table>
<h4>{{ trans('student::local.students_names') }}</h4>
<table>
    <thead>
        <tr>
            <th>{{ trans('student::local.student_number') }}</th>
            <th>{{ trans('student::local.student_name') }}</th>
            <th>{{ trans('student::local.grade') }}</th>
            <th>{{ trans('student::local.division') }}</th>
            <th>{{ trans('student::local.father_mobile') }}</th>
            <th>{{ trans('student::local.mother_mobile') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($commissioner->students as $student)
            <tr>
                <td>{{$student->student_number}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$student->ar_student_name}}
                        {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}
                    @else
                        {{$student->en_student_name}}
                        {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}
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
                <td>{{$student->father->mobile1}}</td>
                <td>{{$student->mother->mobile1_m}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="signature">
    <h4 style="text-align: left; margin-left:80px;"><strong>{{ trans('admin.students_affairs') }}</strong></h4>
</div>	
<htmlpagefooter name="page-footer">
   <p> {PAGENO}</p>
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')