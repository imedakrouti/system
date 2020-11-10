@extends('layouts.backEnd.cpanel')
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
          <form class="form form-horizontal" method="POST" action="{{route('annual-increase.update')}}" >                
                @csrf
                <div class="row">                          
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                        <label>{{ trans('staff::local.start_set_vacation_date') }}</label>
                        <input type="date" class="form-control " value="{{old('set_date')}}"                           
                            name="set_date" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                        <label>{{ trans('staff::local.execute_type') }}</label>
                        <select name="execute_type" class="form-control" id="execute_type">                            
                                <option value="">{{ trans('staff::local.select') }}</option>
                                <option value="departments">{{ trans('staff::local.departments') }}</option>
                                <option value="employees">{{ trans('staff::local.employees') }}</option>                                             
                            </select>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>                  
                </div>
                <div class="row hidden" id="employees">                          
                    <div class="col-lg-6 col-md-6" >
                        <div class="form-group">
                        <label>{{ trans('staff::local.employee_name') }}</label>
                        <select name="employee_id[]" class="form-control select2" multiple id="vacation_type">                            
                            @foreach ($employees as $employee)
                                <option {{old('staff_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                                @if (session('lang') == 'ar')
                                [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                @else
                                [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$staff->en_th_name}}
                                @endif
                                </option>
                            @endforeach

                        </select>
                        <span class="red">{{ trans('staff::local.required') }}</span>                        
                        </div>
                    </div>                  
                </div> 
                <div class="row hidden" id="departments">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                        <label>{{ trans('staff::local.sector_id') }}</label>
                        <select id="sector_id" name="sector_id" class="form-control select2">
                            <option value="">{{ trans('staff::local.select') }}</option>    
                            @foreach ($sectors as $sector)
                                <option value="{{$sector->id}}">
                                {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}</option>
                            @endforeach
                        </select>                                             
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                        <label>{{ trans('staff::local.department_id') }}</label>
                        <select id="department_id"  name="department_id[]" class="form-control select2" multiple>
                            <option value="">{{ trans('staff::local.select') }}</option>    
                                
                        </select>                                          
                        </div>
                    </div>
                </div>   
                <div class="col-lg-2 col-md-6">
                    <div class="form-group row">
                      <label>{{ trans('staff::local.annual_increase_percent') }}</label>
                      <input type="number" min="0" step="10" class="form-control " value="{{old('annual_increase')}}"                           
                        name="annual_increase" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
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
    $('#execute_type').on('change',function () {

        if($('#execute_type').val() == 'employees')
        {
            $('#departments').addClass('hidden');
            $('#employees').removeClass('hidden');
        }else{
            $('#departments').removeClass('hidden');
            $('#employees').addClass('hidden');
        }

        if($('#execute_type').val() == 'departments')
        {
            $('#departments').removeClass('hidden');
            $('#employees').addClass('hidden');
        }else{
            $('#departments').addClass('hidden');
            $('#employees').removeClass('hidden');
        }
    });

    $('#sector_id').on('change', function(){
          var sector_id = $(this).val();                  

          if (sector_id == '') // is empty
          {
            $('#department_id').prop('disabled', true); // set disable                  
          }
          else // is not empty
          {
            $('#department_id').prop('disabled', false);	// set enable                  
            //using
            $.ajax({
              url:'{{route("getDepartmentsBySectorId")}}',
              type:"post",
              data: {
                _method		    : 'PUT',
                sector_id 	  : sector_id,                      
                _token		    : '{{ csrf_token() }}'
                },
              dataType: 'json',
              success: function(data){
                $('#department_id').html(data);                      
              }
            });
          }
    });  
</script>
@endsection