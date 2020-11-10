@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
              <div class="table-responsive">
                    <table id="dynamic-table" class="table table-striped" >
                        <thead class="bg-info white">
                            <tr>
                                <th class="center">{{ trans('staff::local.employee_name') }}</th>
                                @foreach ($salary_components as $com_id)
                                    <th class="center">
                                        {{session('lang') == 'ar' ? $com_id->ar_item : $com_id->en_item}}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
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
                                            
                                    @foreach ($employee->payrollComponents as $item)
                                        @if ($item->employee_id == $employee->id)
                                            <td class="center">
                                                {{$item->value}}
                                            </td>                                      
                                        @endif      
                                                                          
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
