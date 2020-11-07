@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 

    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        {!!$header!!}
    </div>
    <div class="clear"></div>   
    <h4 class="center">{{trans('staff::local.payroll_cash')}} </h4>
    <strong>{{ trans('staff::local.payroll_sheet_name') }} :</strong> {{$sheet_name}} <br>
    <strong>{{ trans('staff::local.payroll_period') }} :</strong> {{$period}}
</htmlpageheader>
<table>
    <thead>
        <tr>      
           <th>#</th>                                                                
            <th>{{trans('staff::local.attendance_id')}}</th>                                
            <th>{{trans('staff::local.employee_name')}}</th>
            <th>{{trans('staff::local.sector')}}</th>
            <th>{{trans('staff::local.department')}}</th>
            <th>{{trans('staff::local.position')}}</th>
            <th>{{trans('staff::local.hiring_date')}}</th>            
            <th>{{trans('staff::local.net_type')}}</th>                                                      
        </tr>
    </thead>
    <tbody>
      @php
          $n=1;
      @endphp
      @foreach ($employees as $employee)
          <tr>
              <td>{{$n}}</td>
              <td>{{$employee->attendance_id}}</td>
              <td class="center">
                @if (session('lang') == 'ar')
                   {{$employee->ar_st_name}} {{$employee->ar_nd_name}} 
                    {{$employee->ar_rd_name}} {{$employee->ar_th_name}}    
                  @else
                   {{$employee->en_st_name}} {{$employee->en_nd_name}} 
                    {{$employee->en_rd_name}} {{$employee->en_th_name}}   
                  @endif    
              </td>                                  
              <td>
                @isset($employee->sector->ar_sector)
                    {{session('lang') == 'ar' ? $employee->sector->ar_sector:$employee->sector->en_sector}}
                @endisset
              </td>
              <td>
                @isset($employee->department->ar_department)
                    {{session('lang') == 'ar' ? $employee->department->ar_department:$employee->department->en_department}}
                @endisset
              </td>
              <td>
                @isset($employee->position->ar_position)
                    {{session('lang') == 'ar' ? $employee->position->ar_position:$employee->position->en_department}}
                @endisset
              </td>
              <td>{{$employee->hiring_date}}</td>              
              <td>{{$employee->value}}</td>                                  
          </tr>
          @php
              $n++;
          @endphp
      @endforeach
      <tr>
          <td colspan="7">{{ trans('staff::local.total_payroll') }}</td>
          <td>{{$total}}</td>                                  
      </tr>
    </tbody>
</table>
<htmlpagefooter name="page-footer">  
    <span style="font-size: 10px;">{DATE j-m-Y} [{{authInfo()->username}}] -{{ trans('staff::local.page') }} {PAGENO}</span>    
    <div class="center">  
        <strong>
            {{ trans('staff::local.hr_manager') }} 	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 
            {{ trans('staff::local.hr_audit') }} 	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;            
            {{ trans('staff::local.chairman') }}	
        </strong>      
    </div>
    
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')