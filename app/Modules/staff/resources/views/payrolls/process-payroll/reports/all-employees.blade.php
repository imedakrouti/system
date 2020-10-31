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
        {{session('lang') == 'ar' ? $payroll_sheet_data->payrollSheet->ar_sheet_name : $payroll_sheet_data->payrollSheet->en_sheet_name}} 
        [{{$payroll_sheet_data->from_date}}] - [{{$payroll_sheet_data->to_date}}]</h4> 
</htmlpageheader>
<table>
    <thead class="bg-info white">
        <tr>
            <th>{{ trans('staff::local.employee_name') }}</th>
            <th>{{ trans('staff::local.working_data') }}</th>
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
                            {{$employee->sector->ar_sector}} - {{$employee->department->ar_department}}
                        @else
                            {{$employee->sector->en_sector}} - {{$employee->department->en_department}}
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
    </tbody>
</table>

<htmlpagefooter name="page-footer">
  {{now()}} - {{authInfo()->username}}
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')