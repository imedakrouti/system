@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 

    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        {!!$header!!}
    </div>
    <div class="clear"></div>   
    <h4 class="center">{{trans('staff::local.salary_slip')}} </h4> 
    [{{\DateTime::createFromFormat("Y-m-d",$payroll_sheet_data->from_date)->format("Y/m/d")}}] - 
    [{{\DateTime::createFromFormat("Y-m-d",$payroll_sheet_data->to_date)->format("Y/m/d")}}]
    <br>
    {{ trans('staff::local.employee_name') }} : 
    @if (session('lang') == 'ar')
        [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} 
        {{$employee->ar_rd_name}} {{$employee->ar_th_name}} <br>
        {{$employee->sector->ar_sector}} - {{$employee->department->ar_department}}      
    @else
        [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}}
        {{$employee->en_rd_name}} {{$employee->en_th_name}} <br>
        {{$employee->sector->en_sector}} - {{$employee->department->en_department}}      
    @endif    
    <br>
    
        
</htmlpageheader>
<table>
    <thead>
        <tr>
            <th>{{ trans('staff::local.salary_components') }}</th>            
            <th>{{ trans('staff::local.value') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employee->payrollComponents as $comp)
            <tr>
                <td>{{$comp->salaryComponents->ar_item}}</td>
                <td>{{$comp->value}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="text-align:left; margin-left: 150px">{{ trans('staff::local.hr_manager') }} </div>
<htmlpagefooter name="page-footer">  
    <span style="font-size: 10px;">{DATE j-m-Y} [{{authInfo()->username}}] -{{ trans('staff::local.page') }} {PAGENO}</span>    

    
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')