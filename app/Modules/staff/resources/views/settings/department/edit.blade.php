@extends('layouts.cpanel')
@section('sidebar')
    @include('layouts.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('staff.setting')}}">{{ trans('staff::admin.settings') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('department.index')}}">{{ trans('staff::admin.departments') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('department.update',$department->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="userinput1">{{ trans('staff::admin.sector') }}</label>
                          <div class="col-md-9">
                            <select name="sector_id" id="findBySectiorId" class="form-control">
                            </select>
                          </div>
                        </div>
                      </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="userinput1">{{ trans('staff::admin.arabic_department') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput1" class="form-control border-primary" value="{{$department->arabicDepartment}}" placeholder="{{ trans('staff::admin.arabic_department') }}"
                              name="arabicDepartment" ">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('staff::admin.english_department') }}</label>
                          <div class="col-md-9">
                            <input type="text"  class="form-control border-primary" value="{{$department->englishDepartment}}" placeholder="{{ trans('staff::admin.english_department') }}"
                            name="englishDepartment" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('staff::admin.department_balance') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="1" max="100"  class="form-control border-primary" value="{{$department->balanceDepartmentLeave}}" placeholder="{{ trans('staff::admin.sort') }}"
                            name="balanceDepartmentLeave" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('staff::admin.sort') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="1" max="100"  class="form-control border-primary" value="{{$department->sort}}" placeholder="{{ trans('staff::admin.sort') }}"
                            name="sort" >
                          </div>
                        </div>
                      </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('department.index')}}';">
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
	    (function getSectorsSelected()
	    {
			 var sectorId = "{{ $department->sector_id }}";
	        $.ajax({
				type:'POST',
				url:'{{route("getSectorsSelected")}}',
				data: {
					_method     : 'PUT',
					sectorId    : sectorId,
					_token      : '{{ csrf_token() }}'
				},
	          dataType:'json',
	          success:function(data){
				$('#findBySectiorId').html(data);
	          }
	        });
		}());
</script>
@endsection
