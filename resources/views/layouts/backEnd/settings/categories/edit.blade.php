@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('categories.index')}}">{{ trans('admin.categories') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('categories.update',$category->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.ar_category_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{$category->ar_category_name}}" placeholder="{{ trans('admin.ar_category_name') }}"
                              name="ar_category_name" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.en_category_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{$category->en_category_name}}" placeholder="{{ trans('admin.en_category_name') }}"
                              name="en_category_name" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.description') }}</label>
                          <div class="col-md-9">
                              <textarea name="description" class="form-control "  cols="30" rows="5">{{$category->description}}</textarea>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.keywords') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{$category->keywords}}" placeholder="{{ trans('admin.keywords') }}"
                              name="keywords" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.display_in_site') }}</label>
                          <div class="col-md-9">
                            <select name="show" class="form-control">
                                <option>{{ trans('admin.select') }}</option>
                                <option {{ ($category->show == trans('admin.yes'))?'selected':''}} value="yes">{{ trans('admin.yes') }}</option>
                                <option {{ ($category->show == trans('admin.no'))?'selected':''}} value="no">{{ trans('admin.no') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.sort') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="0" class="form-control " value="{{$category->sort}}" placeholder="{{ trans('admin.sort') }}"
                              name="sort" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.icon') }}</label>
                          <div class="col-md-9">
                            <input  type="file" name="icon"/>
                          </div>
                        </div>
                      </div>

                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('categories.index')}}';">
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
