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
    <h4 class="center">{{ trans('student::local.statistics_second_lang') }} - {{ trans('student::local.year') }} {{$year_name}}</h4>
</htmlpageheader>

<table>
    <thead>
        <tr>
            <th>{{ trans('student::local.grades') }}</th>
            @foreach ($languages as $lang)
                <th>{{$lang->ar_name_lang}}</th>
            @endforeach            
        </tr>
    </thead>
    <tbody>
        @foreach ($grades as $grade)
        {{-- {{dd($student)}} --}}
            <tr>
                <td>{{$grade->ar_grade_name}}</td>
                @foreach ($students as $student)
                    @if ($student['grade'] == $grade->id)
                        <td>{{$student['count']}}</td>                        
                    @endif
                @endforeach                                             
            </tr>
        @endforeach
        <tr>
            <td class="red"><strong>{{ trans('student::local.totalStudents') }}</strong></td>
            @foreach ($languages as $lang)  
                @foreach ($counting as $count)
                    @if ($lang->id == $count['lang'])
                        <td class="red"><strong>{{$count['count']}}</strong></td>                        
                    @endif
                @endforeach                  
            @endforeach  
        </tr>
    </tbody>
</table>


<div class="signature">
    <h3 style="text-align: left; margin-left:80px;"><strong>{{ trans('admin.students_affairs') }}</strong></h3>
</div>
@include('layouts.backEnd.layout-report.footer')