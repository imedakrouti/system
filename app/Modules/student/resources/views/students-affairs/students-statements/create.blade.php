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
            <li class="breadcrumb-item"><a href="{{route('statements.index')}}">{{ trans('student::local.students_statements') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('statements.store')}}" id="formData">
                @csrf
                <div class="form-body">
                  <h4 class="form-section"> {{ $title }} | <span class="blue">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</span></h4>
                    @include('layouts.backEnd.includes._msg')
                    @if(session('error'))
                      <h3 class="red"> {{session('error')}}</h3>
                    @endif 
                    <div class="row">
                      <div class="col-md-3">
                        <select name="from_division_id" class="form-control" id="division_id" required>
                            <option value="">{{ trans('student::local.divisions') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{$division->id}}">
                                    {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                            @endforeach
                        </select>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                    </div> 
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <h5 class="mb-1">{{ trans('student::local.move_from') }}</h5>
                        <select name="from_year_id" class="form-control" id="year_id">
                            @foreach ($years as $year)
                              @if (currentYear() == $year->id )
                                  <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                    
                              @endif
                            @endforeach
                        </select> 
                      </div>
                      <div class="col-md-3">
                        <h5 class="mb-1">{{ trans('student::local.move_to') }}</h5>
                        <select name="to_year_id" class="form-control" id="year_id" required>
                              <option value="">{{ trans('student::local.year') }}</option>
                              @foreach ($years as $year)
                                  @if (currentYear() != $year->id)
                                    <option value="{{$year->id}}">{{$year->name}}</option>                                                                          
                                  @endif
                              @endforeach
                        </select>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                      </div> 

                    </div>
                    <div class="row">
                      <div class="col-md-3">
                          <select name="from_status_id[]" class="form-control select2" multiple id="status_id" required>
                              <option value="">{{ trans('student::local.register_status_id') }}</option>
                              @foreach ($regStatus as $status)
                                  <option value="{{$status->id}}">{{session('lang') == 'ar' ? $status->ar_name_status : $status->en_name_status}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                      </div>
                      <div class="col-md-3">
                          <select name="to_status_id" class="form-control" id="status_id" required>
                              <option value="">{{ trans('student::local.register_status_id') }}</option>
                              @foreach ($regStatus as $status)
                                  <option value="{{$status->id}}">{{session('lang') == 'ar' ? $status->ar_name_status : $status->en_name_status}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                      </div>

                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('student::local.data_migration') }}
                    </button>
                      
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('statements.index')}}';">
                    <i class="ft-x"></i> {{ trans('admin.cancel') }}
                  </button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
    <script>
      $("form").submit(function(e){
        event.preventDefault();
        swal({
                title: "{{trans('student::local.data_migration')}}",
                text: "{{trans('student::local.migration_warning')}}",
                showCancelButton: true,
                confirmButtonColor: "#87B87F",
                confirmButtonText: "{{trans('msg.yes')}}",
                cancelButtonText: "{{trans('msg.no')}}",
                closeOnConfirm: false,
            },
            function(){
                $("#formData").submit();
        });
        
    });
    </script>
@endsection

 