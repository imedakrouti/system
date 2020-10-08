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

<h4 class="center">{{ trans('student::local.transfers') }} 
    [{{ DateTime::createFromFormat("Y-m-d",$from_date)->format("Y/m/d")}} - 
    {{ DateTime::createFromFormat("Y-m-d",$to_date)->format("Y/m/d")}}]</h4>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('student::local.student_number') }}</th>
            <th>{{ trans('student::local.student_name') }}</th>
            <th>{{ trans('student::local.classroom') }}</th>
            <th>{{ trans('student::local.grade') }}</th>
            <th>{{ trans('student::local.division') }}</th>
            <th>{{ trans('student::local.leaved_date') }}</th>            
            <th>{{ trans('student::local.to_school') }}</th>            
        </tr>
    </thead>
    <tbody>
        {{$n=1}}
        @foreach ($transfers as $request)
            <tr>
                <td>{{$n}}</td>
                <td>{{$request->students->student_number}}</td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$request->students->ar_student_name}} {{$request->students->father->ar_st_name}}
                        {{$request->students->father->ar_nd_name}} {{$request->students->father->ar_rd_name}}
                    @else
                        {{$request->students->en_student_name}} {{$request->students->father->en_st_name}}
                        {{$request->students->father->en_nd_name}} {{$request->students->father->en_rd_name}}
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$request->ar_name_classroom}}
                    @else
                        {{$request->en_name_classroom}}
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$request->students->grade->ar_grade_name}}
                    @else
                        {{$request->students->grade->en_grade_name}}
                    @endif
                </td>
                <td>
                    @if (session('lang') == 'ar')
                        {{$request->students->division->ar_division_name}}
                    @else
                        {{$request->students->division->en_division_name}}
                    @endif
                </td>
                <td>{{DateTime::createFromFormat("Y-m-d",$request->leaved_date)->format("Y/m/d")}}</td>    
                <td>{{$request->schools->school_name}}</td>         
            </tr>
            {{$n++}}
        @endforeach

    </tbody>
</table>

@include('layouts.backEnd.layout-report.footer')