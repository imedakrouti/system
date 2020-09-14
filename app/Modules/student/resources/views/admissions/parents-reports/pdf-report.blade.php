  @include('layouts.backEnd.layout-report.header')
  @include('student::_includes._header-admission')
  <h4 class="center">{{ trans('student::local.parent_reports') }}</h4>

    <h4>{{ trans('student::local.report_title') }} : {{$reports->report_title}}</h4>

    <h4>{{ trans('student::local.parent_name') }} :      
        @if (session('lang') == 'ar')
            {{$reports->fathers['ar_st_name']}} {{$reports->fathers['ar_nd_name']}} {{$reports->fathers['ar_rd_name']}} {{$reports->fathers['ar_th_name']}}
        @else
            {{$reports->fathers['en_st_name']}} {{$reports->fathers['en_nd_name']}} {{$reports->fathers['en_rd_name']}} {{$reports->fathers['en_th_name']}}
        @endif   
    </h4> 
    <h4><u>{{ trans('student::local.sons') }}</u></h4>
    <ol>
        @foreach ($mothers as $mother)
            @foreach ($mother->students as $student)
            <li>{{$student->ar_student_name}} [ {{$mother->full_name}} ]</li>
            @endforeach                
        @endforeach        
    </ol>

    <hr>
    <p style="text-align: justify">{{$reports->report}}</p>
@include('layouts.backEnd.layout-report.footer')