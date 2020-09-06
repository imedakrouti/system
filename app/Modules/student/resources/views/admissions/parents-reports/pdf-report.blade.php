  @include('layouts.backEnd.layout-report.header')
    <h4 class="mt-1">{{ trans('student::local.report_title') }} : {{$reports->report_title}}</h4>
    <h6>{{ trans('student::local.created_by') }} : {{$reports->admin['name']}}</h6>
    <h6>{{ trans('student::local.created_at') }} : {{$reports->created_at}}</h6>
    <h6>{{ trans('student::local.updated_at') }} : {{$reports->updated_at}}</h6>
    <h4 class="mt-1">{{ trans('student::local.parent_name') }} :         
        @if (session('lang') == trans('admin.ar'))
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
    <h4 >{{$reports->report}}</h4>    
    @include('layouts.backEnd.layout-report.footer')