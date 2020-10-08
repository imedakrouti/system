@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>            
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
          <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h4>{{ trans('student::local.statistics_note') }} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
                    <form action="#" method="get" id="filterForm" target="_blank">
                          <div class="row mt-1">      
                                <div class="col-md-2">
                                    <select name="division_id[]" class="form-control select2" multiple id="filter_division_id">                                      
                                        @foreach ($divisions as $division)
                                            <option {{session('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                                                {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                                        @endforeach
                                    </select>
                                </div>  
                                <div class="col-md-2">
                                    <input type="date" name="from_date" class="form-control">
                                </div> 
                                <div class="col-md-2">
                                    <input type="date" name="to_date" class="form-control">
                                </div>                                                                                        
                          </div>
                    </form>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">    
            <h4 class="purple">{{ trans('student::local.reports') }}</h4>                    
              <div class="row">
                <div class="col-md-4">                    
                    <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="list-group">
                            <button type="button" onclick="permissions()" class="list-group-item list-group-item-action">{{trans('student::local.daily_requests') }}</button>
                            <button type="button" onclick="parentRequests()" class="list-group-item list-group-item-action">{{trans('student::local.parent_request') }}</button>
                            <button type="button" onclick="leaveRequests()" class="list-group-item list-group-item-action">{{trans('student::local.leave_requests') }}</button>        
                            <button type="button" onclick="transfers()" class="list-group-item list-group-item-action">{{trans('student::local.transfers') }}</button>        
                          </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        function permissions()
        {
            $('#filterForm').attr('action',"{{route('reports.permissions')}}");
            $('#filterForm').submit();
        }  

        function parentRequests()
        {
            $('#filterForm').attr('action',"{{route('reports.parent-requests')}}");
            $('#filterForm').submit();
        } 

        function leaveRequests()
        {
            $('#filterForm').attr('action',"{{route('reports.leave-requests')}}");
            $('#filterForm').submit();
        }  

        function transfers()
        {
            $('#filterForm').attr('action',"{{route('reports.transfers')}}");
            $('#filterForm').submit();
        }                                
    </script>
@endsection
