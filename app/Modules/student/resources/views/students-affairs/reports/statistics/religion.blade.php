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
    <h4 class="center">{{ trans('student::local.statistics_religion') }}</h4>
</htmlpageheader>

<table style="direction: {{session('lang') == 'ar' ? 'rtl' :'ltr'}}">
    <thead>
        <tr>
            <th>{{ trans('student::local.grades') }}</th>
            @foreach ($religions as $religion)
                <th>
                   @if ($religion['religion'] == 'muslim')
                       {{ trans('student::local.muslim') }}
                   @else
                       {{ trans('student::local.non_muslim') }}                       
                   @endif
                </th>
            @endforeach            
        </tr>
    </thead>
    <tbody>
        @foreach ($grades as $grade)        
            <tr>
                <td>
                    @if (session('lang') == 'ar')
                        {{$grade->ar_grade_name}}
                    @else
                        {{$grade->en_grade_name}}
                    @endif
                </td>
                @foreach ($students as $student)
                    @if ($student['grade'] == $grade->id)
                        <td>{{$student['count']}}</td>                        
                    @endif
                @endforeach                                             
            </tr>
        @endforeach
        <tr>
            <td class="red"><strong>{{ trans('student::local.totalStudents') }}</strong></td>
            @foreach ($religions as $religion)  
                @foreach ($counting as $count)
                    @if ($religion['id'] == $count['religion'])
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