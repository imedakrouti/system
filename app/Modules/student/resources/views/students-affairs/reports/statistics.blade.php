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
                    <form action="#" method="get" id="filterForm" >
                          <div class="row mt-1">
                              <div class="col-md-2">
                                  <select name="year_id" class="form-control" id="filter_year_id">
                                      <option value="">{{ trans('student::local.year') }}</option>
                                      @foreach ($years as $year)
                                          <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                    
                                      @endforeach
                                  </select>
                              </div>        
                              <div class="col-md-2">
                                  <select name="division_id" class="form-control" id="filter_division_id">
                                      <option value="">{{ trans('student::local.divisions') }}</option>
                                      @foreach ($divisions as $division)
                                          <option value="{{$division->id}}">
                                              {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-md-2">
                                  <select name="grade_id" class="form-control" id="filter_grade_id">
                                      <option value="">{{ trans('student::local.grades') }}</option>
                                      @foreach ($grades as $grade)
                                          <option value="{{$grade->id}}">
                                              {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                                      @endforeach
                                  </select>
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
              <div class="row">
                <div class="col-md-4">
                    <div class="card-content collapse show">
                        <div class="card-body">            
                          <ul class="list-group">
                            <li class="list-group-item"><a onclick="statistics()" class="dropdown-item" href="#">{{trans('student::local.statistics_all_students') }}</a></li>  
                            <li class="list-group-item"><a onclick="secondLangStatistics()" class="dropdown-item" href="#">{{trans('student::local.statistics_second_lang') }}</a></li>  
                            <li class="list-group-item"><a onclick="statistics()" class="dropdown-item" href="#">{{trans('student::local.statistics_reg_status') }}</a></li>  
                          </ul>
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
        function statistics()
        {
            $('#filterForm').attr('action',"{{route('statistics.report')}}");
            $('#filterForm').submit();
        }  

        function secondLangStatistics()
        {
            $('#filterForm').attr('action',"{{route('statistics.second-lang')}}");
            $('#filterForm').submit();
        }               
    </script>
@endsection
