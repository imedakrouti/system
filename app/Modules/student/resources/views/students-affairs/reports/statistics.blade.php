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
                                  <select name="year_id" class="form-control select2" id="filter_year_id">                                      
                                      @foreach ($years as $year)
                                          <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                    
                                      @endforeach
                                  </select>
                              </div>        
                              <div class="col-md-2">
                                  <select name="division_id[]" class="form-control select2" multiple id="filter_division_id">                                      
                                      @foreach ($divisions as $division)
                                          <option {{session('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                                              {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
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
                          <div class="list-group">
                            <button type="button" onclick="statistics()" class="list-group-item list-group-item-action">{{trans('student::local.statistics_all_students') }}</button>
                            <button type="button" onclick="secondLangStatistics()" class="list-group-item list-group-item-action">{{trans('student::local.statistics_second_lang') }}</button>
                            <button type="button" onclick="regStatusStatistics()" class="list-group-item list-group-item-action">{{trans('student::local.statistics_reg_status') }}</button>        
                            <button type="button" onclick="religionStatistics()" class="list-group-item list-group-item-action">{{trans('student::local.statistics_religion') }}</button>        
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

        function regStatusStatistics()
        {
            $('#filterForm').attr('action',"{{route('statistics.reg-status')}}");
            $('#filterForm').submit();
        }  

        function religionStatistics()
        {
            $('#filterForm').attr('action',"{{route('statistics.religion')}}");
            $('#filterForm').submit();
        }                                
    </script>
@endsection
