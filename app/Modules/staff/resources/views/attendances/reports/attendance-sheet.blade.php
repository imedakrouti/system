@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 
    <div class="left-header" style="margin-top: -20px">
        <img style="width: 75px;height:75px;" src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        <span style="text-align: center">{!!$header!!}</span>
    </div>
    <div class="clear"></div>
    </htmlpageheader>
    <hr>
    <div class="center"> <strong>{{ trans('staff::local.attendance_sheet') }}</strong></div>

    <table class="table table-striped" >
        <thead class="bg-info white">
            <tr class="center">                                                                                      
                <th width=200>{{trans('staff::local.employee_name')}}</th>
                <th>{{trans('staff::local.working_data')}}</th>              
                <th>{{trans('staff::local.hiring_date')}}</th>
                <th>{{trans('staff::local.leave_date')}}</th>
                <th>{{trans('staff::local.attend_days')}}</th>
                <th>{{trans('staff::local.absent_days')}}</th>                                                      
                <th>{{trans('staff::local.total_lates')}}</th>                             
            </tr>    
        </thead>
        <tbody id="summary">
            <tr>
                <td>{{$employee_name}}</td>
                <td>{{$working_data}}</td>
                <td>{{$hiring_date}}</td>
                <td>{{$leave_date}}</td>
                <td>{{$attend_days}}</td>
                <td>{{$absent_days}}</td>
                <td>{{$total_lates}}</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table id="dynamic-table" class="table table-striped" >
        <thead class="bg-info white">
            <tr>                                                                
                  <th>#</th>  
                  <th>{{trans('staff::local.week')}}</th>
                  <th>{{trans('staff::local.date')}}</th>                                                      
                  <th>{{trans('staff::local.on_duty_time')}}</th>
                  <th>{{trans('staff::local.off_duty_time')}}</th>                                                        
                  <th>{{trans('staff::local.clock_in')}}</th>
                  <th>{{trans('staff::local.clock_out')}}</th>                            
                  <th>{{trans('staff::local.no_attend_fp')}}</th>
                  <th>{{trans('staff::local.no_leave_fp')}}</th>                  
                  <th>{{trans('staff::local.absent')}}</th>                  
                  <th>{{trans('staff::local.lates_after_request')}}</th>                                    
            </tr>
        </thead>
        <tbody>
            @php
                $n= 1
            @endphp
            @foreach ($logs as $log)
                <tr>
                    <td>{{$n}}</td>
                    <td>
                        @switch($log->week)
                            @case('Saturday')
                                {{trans('staff::local.saturday')}}
                                @break
                            @case('Sunday')
                                {{trans('staff::local.sunday')}}
                                @break
                            @case('Monday')
                                {{trans('staff::local.monday')}}
                                @break
                            @case('Tuesday')
                                {{trans('staff::local.tuesday')}}
                                @break    
                            @case('Wednesday')
                                {{trans('staff::local.wednesday')}}
                                @break
                            @case('Thursday')
                                {{trans('staff::local.thursday')}}
                                @break                                                              
                            @default
                                {{trans('staff::local.friday')}}
                        @endswitch
 
                    </td>
                    <td>{{$log->selected_date}}</td>
                    <td>{{$log->on_duty_time}}</td>
                    <td>{{$log->off_duty_time}}</td>
                    <td>{{$log->clock_in}}</td>
                    <td>{{$log->clock_out}}</td>
                    <td>
                        @if($log->no_attend != 0 )                                         
                            1
                        @endif                        
                    </td>
                    <td>
                        @if($log->no_leave != 0 )                                         
                            1
                        @endif    
                    </td>                    
                    <td>
                        @if ($log->absent_after_holidays == 'True')
                            {{ trans('staff::local.employee_absent') }}                     
                        @endif
                        @switch($log->vacation_type)
                            @case('Start work')
                                {{trans('staff::local.startWork')}}
                                @break
                            @case('End work')
                                {{trans('staff::local.end_work')}}
                                @break
                            @case('Sick leave')
                                {{trans('staff::local.sick_leave')}}
                                @break
                            @case('Regular vacation')
                                {{trans('staff::local.regular_vacation')}}
                                @break
                            @case('Vacation without pay')
                                {{trans('staff::local.vacation_without_pay')}}
                                @break
                            @case('Work errand')
                                {{trans('staff::local.work_errand')}}
                                @break
                            @case('Training')
                                {{trans('staff::local.training')}}
                                @break
                            @case('Casual vacation')
                                {{trans('staff::local.casual_vacation')}}
                                @break
                            @default
                                
                        @endswitch
                    </td>
                    <td>{{$log->main_lates == 0 ? '':$log->main_lates}}</td>
                </tr>
                {{$n++}}
            @endforeach
        </tbody>
    </table>
<htmlpagefooter name="page-footer">
   
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')