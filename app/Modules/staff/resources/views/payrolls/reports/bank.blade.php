@extends('layouts.backEnd.cpanel')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('payroll-process.index')}}">{{ trans('staff::local.process_payroll') }}</a></li>
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
          <h5><strong>{{ trans('staff::local.payroll_sheet_name') }} :</strong> {{$sheet_name}}</h5>
          <h5><strong>{{ trans('staff::local.payroll_period') }} :</strong> {{$period}}</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
              <div class="table-responsive">
                  <form action="" id='formData' method="post">                    
                    @csrf
                    <table id="dynamic-table" class="table data-table" >
                        <thead class="bg-info white">
                            <tr>      
                               <th>#</th>                                                                
                                <th>{{trans('staff::local.attendance_id')}}</th>                                
                                <th>{{trans('staff::local.employee_name')}}</th>
                                <th>{{trans('staff::local.sector')}}</th>
                                <th>{{trans('staff::local.department')}}</th>
                                <th>{{trans('staff::local.position')}}</th>
                                <th>{{trans('staff::local.hiring_date')}}</th>
                                <th>{{trans('staff::local.salary_bank_name')}}</th>
                                <th>{{trans('staff::local.bank_account')}}</th>
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
                                          <a href="{{route('employees.show',$employee->id)}}">
                                              [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} 
                                              {{$employee->ar_rd_name}} {{$employee->ar_th_name}}                                                 
                                          </a>    
                                      @else
                                          <a href="{{route('employees.show',$employee->id)}}">
                                              [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} 
                                              {{$employee->en_rd_name}} {{$employee->en_th_name}}                                                 
                                          </a>    
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
                                  <td>{{$employee->salary_bank_name}}</td>
                                  <td>{{$employee->salary_bank_account}}</td>                                  
                                  <td>{{$employee->value}}</td>                                  
                              </tr>
                              @php
                                  $n++;
                              @endphp
                          @endforeach
                        </tbody>
                    </table>
                  </form>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        $(function () {
            var myTable = $('#dynamic-table').DataTable({
            @include('layouts.backEnd.includes.datatables._datatableConfig')            
                buttons: [
                    // delete btn
                    @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'payroll-process.destroy'])

                    // default btns
                    @include('layouts.backEnd.includes.datatables._datatableBtn')
                ],          
              @include('layouts.backEnd.includes.datatables._datatableLang')
          });
          @include('layouts.backEnd.includes.datatables._multiSelect')
        });
    </script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
