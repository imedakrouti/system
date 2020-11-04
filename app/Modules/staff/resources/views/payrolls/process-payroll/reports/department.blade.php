@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 

    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        {!!$header!!}
    </div>
    <div class="clear"></div>   
    <h4 class="center">{{trans('staff::local.payroll_sheet')}} 
        {{$department_name}} 
        [{{\DateTime::createFromFormat("Y-m-d",$payroll_sheet_data->from_date)->format("Y/m/d")}}] - 
        [{{\DateTime::createFromFormat("Y-m-d",$payroll_sheet_data->to_date)->format("Y/m/d")}}]</h4> 
        <span style="font-size: 10px;">{DATE j-m-Y} [{{authInfo()->username}}] -{{ trans('staff::local.page') }} {PAGENO}</span>    
</htmlpageheader>
@php
    $total = 0;
@endphp
<table>
    <thead class="bg-info white">
        <tr>
            <th>{{ trans('staff::local.employee_name') }}</th>
            <th>{{ trans('staff::local.department') }}</th>
            @foreach ($salary_components as $com_id)
                <th>
                    {{session('lang') == 'ar' ? $com_id->ar_item : $com_id->en_item}}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>
                    @if (session('lang') == 'ar')
                    [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} 
                    {{$employee->ar_rd_name}} {{$employee->ar_th_name}}    
                    @else
                    [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} 
                    {{$employee->en_rd_name}} {{$employee->en_th_name}}    
                    @endif    
                </td>    
                <td>
                    @isset($employee->sector->ar_sector)
                        @if (session('lang') == 'ar' )
                           {{$employee->department->ar_department}}
                        @else
                            {{$employee->department->en_department}}
                        @endif                                            
                    @endisset
                </td>
                        
                @foreach ($employee->payrollComponents as $item)
                    @if ($item->employee_id == $employee->id)
                        <td>
                            {{$item->value}}
                        </td>                                      
                    @endif                                                            
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><strong>{{ trans('staff::local.total_payroll') }}</strong></td>  
            @foreach ($totals as $total)                               
                <td>                        
                    <strong>{{$total->sum}}</strong>
                </td>                                                                                                                            
            @endforeach
        </tr>
    </tbody>
  
</table>


<htmlpagefooter name="page-footer">  
    <div class="center">  
        <strong>
            {{ trans('staff::local.hr_manager') }} 	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 
            {{ trans('staff::local.hr_audit') }} 	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;
            {{ trans('staff::local.school_manager') }}	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
            {{ trans('staff::local.chairman') }}	
        </strong>      
    </div>
    
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')