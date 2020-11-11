@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 

    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        {!!$header!!}
    </div>
    <div class="clear"></div>   
    <h4 class="center">{{trans('staff::local.employees_no_timetable')}} </h4>
    
</htmlpageheader>
<table>
    <thead>
        <tr>      
           <th>#</th>                                                                
            <th>{{trans('staff::local.attendance_id')}}</th>                                
            <th>{{trans('staff::local.employee_name')}}</th>   
            <th>{{trans('staff::local.working_data')}}</th>                                                      
            <th>{{trans('staff::local.position')}}</th>
            <th>{{trans('staff::local.mobile1')}}</th>            
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
                @if (!empty($employee->sector->ar_sector))
                    @if (session('lang') == 'ar')
                        {{$employee->sector->ar_sector}} - {{$employee->department->ar_department}}
                    @else
                        {{$employee->sector->en_sector}} - {{$employee->department->en_department}}
                    @endif                      
                @endif
              </td>                                                                  
              <td>
                @isset($employee->position->ar_position)
                    {{session('lang') == 'ar' ? $employee->position->ar_position:$employee->position->en_department}}
                @endisset
              </td>
              <td>{{$employee->mobile1}}</td>                            
          </tr>
          @php
              $n++;
          @endphp
      @endforeach
    </tbody>
</table>
<htmlpagefooter name="page-footer">  
    <span style="font-size: 10px;">{DATE j-m-Y} [{{authInfo()->username}}] -{{ trans('staff::local.page') }} {PAGENO}</span>    
    
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')