@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>  
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">                      
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>          
    </div>  
    <div class="content-header-right col-md-6 col-12 mb-1">      
      <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        <a href="#"  onclick="setDates()" class="btn btn-success box-shadow round mr-1"><i class="la la-ban"></i> {{ trans('learning::local.attendance') }}</a>          
      </div>    
  </div>  
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <table class="table" id="dynamic-table">
          <thead>
            <tr>
              <th>{{ trans('learning::local.student_name') }}</th>
              <th>{{ trans('learning::local.week_1') }} 
                <a href="#">{{ trans('learning::local.edit') }}</a>
              </th>
              <th>{{ trans('learning::local.week_2') }}
                <a href="#">{{ trans('learning::local.edit') }}</a>
              </th>
              <th>{{ trans('learning::local.week_3') }}
                <a href="#">{{ trans('learning::local.edit') }}</a>
              </th>
              <th>{{ trans('learning::local.week_4') }}
                <a href="#">{{ trans('learning::local.edit') }}</a>
              </th>
              <th>{{ trans('learning::local.total_mark') }}</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@include('learning::teacher.absences.includes._set-date')
@endsection
@section('script')
    <script>
      function setDates() {
        $('#set_dates').modal('show');
      }

    </script>
@endsection