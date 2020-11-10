@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 

    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        {!!$header!!}
    </div>
    <div class="clear"></div>   
    <h4 class="center">{{trans('staff::local.employees_insurance')}} </h4>
    {{$sector_name}} - {{$department_name}} 
</htmlpageheader>
<table>
    <thead>
        <tr>      
           <th>#</th>                                                                
            <th>{{trans('staff::local.attendance_id')}}</th>                                
            <th>{{trans('staff::local.employee_name')}}</th>   
            <th>{{trans('staff::local.position')}}</th>
            <th>{{trans('staff::local.mobile1')}}</th>            
            <th>{{trans('staff::local.social_insurance_num')}}</th>            
            <th>{{trans('staff::local.social_insurance_date')}}</th>                                                      
            <th>{{trans('staff::local.insurance_value')}}</th>                                                      
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
                @isset($employee->position->ar_position)
                    {{session('lang') == 'ar' ? $employee->position->ar_position:$employee->position->en_department}}
                @endisset
              </td>
              <td>{{$employee->mobile1}}</td>              
              <td>{{$employee->social_insurance_num}}</td>                                  
              <td>{{$employee->social_insurance_date}}</td>                                  
              <td>{{$employee->insurance_value}}</td>                                  
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