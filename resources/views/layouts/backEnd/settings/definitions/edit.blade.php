@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('definitions.index')}}">{{ trans('admin.definitions') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('definitions.update',$definition->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.department') }}</label>
                          <div class="col-md-9">
                            <select name="department_id" id="department_id" class="form-control">
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.specification') }}</label>
                          <div class="col-md-9">
                            <select name="specification_id" id="specification_id" class="form-control">
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.ar_value') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{$definition->ar_value}}" placeholder="{{ trans('admin.ar_value') }}"
                              name="ar_value">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.en_value') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{$definition->en_value}}" placeholder="{{ trans('admin.en_value') }}"
                              name="en_value">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.sort') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="0" class="form-control " value="{{$definition->sort}}" placeholder="{{ trans('admin.sort') }}"
                              name="sort">
                          </div>
                        </div>
                    </div>


                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('definitions.index')}}';">
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
	    (function getDepartmentSelected()
	    {
			 var department_id = "{{ $definition->department_id }}";
	        $.ajax({
				type:'POST',
				url:'{{route("department.selected")}}',
				data: {
					_method     : 'PUT',
					department_id    : department_id,
					_token      : '{{ csrf_token() }}'
				},
	          dataType:'json',
	          success:function(data){
				$('#department_id').html(data);
	          }
	        });
		}());
        (function getSpecificationSelected()
	    {
			 var specification_id = "{{ $definition->specification_id }}";
	        $.ajax({
				type:'POST',
				url:'{{route("specification.selected")}}',
				data: {
					_method     : 'PUT',
					specification_id    : specification_id,
					_token      : '{{ csrf_token() }}'
				},
	          dataType:'json',
	          success:function(data){
				$('#specification_id').html(data);
	          }
	        });
		}());
</script>
@endsection
