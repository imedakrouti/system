@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('departments.index')}}">{{ trans('admin.departments') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('departments.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.ar_department_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('ar_department_name')}}" placeholder="{{ trans('admin.ar_department_name') }}"
                              name="ar_department_name" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.en_department_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('en_department_name')}}" placeholder="{{ trans('admin.en_department_name') }}"
                              name="en_department_name" >
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.category') }}</label>
                          <div class="col-md-9">
                            <select name="category_id" id="category_id" class="form-control">
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.description') }}</label>
                          <div class="col-md-9">
                              <textarea name="description" class="form-control "  cols="30" rows="5">{{old('description')}}</textarea>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.keywords') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('keywords')}}" placeholder="{{ trans('admin.keywords') }}"
                              name="keywords">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.display_in_site') }}</label>
                          <div class="col-md-9">
                            <select name="show" class="form-control">
                                <option>{{ trans('admin.select') }}</option>
                                <option {{ (old('show') == 'yes')?'selected':''}} value="yes">{{ trans('admin.yes') }}</option>
                                <option {{ (old('show') == 'no')?'selected':''}} value="no">{{ trans('admin.no') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.sort') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="0" class="form-control " value="{{old('sort')}}" placeholder="{{ trans('admin.sort') }}"
                              name="sort">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.department_image') }}</label>
                          <div class="col-md-9">
                            <input  type="file" name="department_image"/>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('departments.index')}}';">
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
    	(function getCategories()
	    {
	        $.ajax({
	          type:'ajax',
	          method:'get',
	          url:'{{route("get.categories")}}',
	          dataType:'json',
	          success:function(data){
	            $('#category_id').html(data);
	          }
	        });
		}());
</script>
@endsection
