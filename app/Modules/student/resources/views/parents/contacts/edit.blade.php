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
            <li class="breadcrumb-item"><a href="{{route('contacts.index',$contact->father_id)}}">{{ trans('student::local.contacts') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('contacts.update',$contact->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.relative_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('relative_name',$contact->relative_name)}}" placeholder="{{ trans('student::local.relative_name') }}"
                              name="relative_name" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.relative_mobile') }}</label>
                          <div class="col-md-9">
                            <input type="number" class="form-control " value="{{old('relative_mobile',$contact->relative_mobile)}}" placeholder="{{ trans('student::local.relative_mobile') }}"
                              name="relative_mobile" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group row">
                        <label class="col-md-3 label-control">{{ trans('student::local.relative_relation') }}</label>
                        <div class="col-md-9">                    
                            <select name="relative_relation" class="form-control" required>
                                <option value="">{{ trans('student::local.select') }}</option>
                                <option {{old('relative_relation',$contact->relative_relation) == trans('student::local.grand_pa') ||
                                old('relative_relation',$contact->relative_relation) == 'grand_pa'
                                ?'selected':''}} value="grand_pa">{{ trans('student::local.grand_pa') }}</option>
                                <option {{old('relative_relation',$contact->relative_relation) == trans('student::local.grand_ma') ||
                                old('relative_relation',$contact->relative_relation) == 'grand_ma'
                                ?'selected':''}} value="grand_ma">{{ trans('student::local.grand_ma') }}</option>                                
                                <option {{old('relative_relation',$contact->relative_relation) == trans('student::local.uncle') ||
                                old('relative_relation',$contact->relative_relation) == 'uncle'
                                ?'selected':''}} value="uncle">{{ trans('student::local.uncle') }}</option>                                
                                <option {{old('relative_relation',$contact->relative_relation) == trans('student::local.aunt') ||
                                old('relative_relation',$contact->relative_relation) == 'aunt'
                                ?'selected':''}} value="aunt">{{ trans('student::local.aunt') }}</option>                                
                                <option {{old('relative_relation',$contact->relative_relation) == trans('student::local.neighbor') ||
                                old('relative_relation',$contact->relative_relation) == 'neighbor'
                                ?'selected':''}} value="neighbor">{{ trans('student::local.neighbor') }}</option>                                
                                <option {{old('relative_relation',$contact->relative_relation) == trans('student::local.other') ||
                                old('relative_relation',$contact->relative_relation) == 'other'
                                ?'selected':''}} value="other">{{ trans('student::local.other') }}</option>                                
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.relative_notes') }}</label>
                          <div class="col-md-9">                            
                              <textarea name="relative_notes" class="form-control" cols="30" rows="5">{{old('relative_notes',$contact->relative_notes)}}</textarea>
                          </div>
                        </div>
                    </div> 
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('contacts.index',$contact->father_id)}}';">
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
