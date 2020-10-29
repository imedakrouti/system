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
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('salary-components.index')}}">{{ trans('staff::local.salary_components') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('salary-components.update',$salaryComponent->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.ar_item') }}</label>
                              <input type="text" class="form-control " value="{{old('ar_item',$salaryComponent->ar_item)}}" 
                              placeholder="{{ trans('staff::local.ar_item') }}"
                                name="ar_item" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.en_item') }}</label>
                              <input type="text" class="form-control " value="{{old('en_item',$salaryComponent->en_item)}}" 
                              placeholder="{{ trans('staff::local.en_item') }}"
                                name="en_item" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>    
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.type') }}</label>
                              <select name="type" class="form-control" required>
                                  <option value="">{{ trans('staff::local.select') }}</option>
                                  <option {{old('type',$salaryComponent->type) == trans('staff::local.fixed') ||
                                  old('type',$salaryComponent->type) == 'fixed' ? 'selected':'' }} value="fixed">{{ trans('staff::local.fixed') }}</option>
                                  <option {{old('type',$salaryComponent->type) == trans('staff::local.variable') ||
                                  old('type',$salaryComponent->type) == 'variable' ? 'selected':'' }} value="variable">{{ trans('staff::local.variable') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.sort') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('sort',$salaryComponent->sort)}}" 
                              placeholder="{{ trans('staff::local.sort') }}"
                                name="sort" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>                         
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.registration') }}</label>
                              <select name="registration" class="form-control" required>
                                  <option value="">{{ trans('staff::local.select') }}</option>
                                  <option {{old('registration',$salaryComponent->registration) == trans('staff::local.employee_calc') ||
                                  old('registration',$salaryComponent->registration) == 'employee_calc' ? 'selected':'' }} value="employee">{{ trans('staff::local.employee_calc') }}</option>
                                  <option {{old('registration',$salaryComponent->registration) == trans('staff::local.payroll_calc')||
                                    old('registration',$salaryComponent->registration) == 'payroll_calc' ? 'selected':'' }} value="payroll">{{ trans('staff::local.payroll_calc') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>                        
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.calculate') }}</label>
                              <select name="calculate" class="form-control" required>
                                  <option value="">{{ trans('staff::local.select') }}</option>
                                  <option {{old('calculate',$salaryComponent->calculate) == trans('staff::local.net_type')||
                                    old('calculate',$salaryComponent->calculate) == 'net_type' ? 'selected':'' }} value="net">{{ trans('staff::local.net_type') }}</option>
                                  <option {{old('calculate',$salaryComponent->calculate) == trans('staff::local.earn_type')||
                                    old('calculate',$salaryComponent->calculate) == 'earn_type' ? 'selected':'' }} value="earn">{{ trans('staff::local.earn_type') }}</option>
                                  <option {{old('calculate',$salaryComponent->calculate) == trans('staff::local.deduction_type')||
                                    old('calculate',$salaryComponent->calculate) == 'deduction_type' ? 'selected':'' }} value="deduction">{{ trans('staff::local.deduction_type') }}</option>
                                  <option {{old('calculate',$salaryComponent->calculate) == trans('staff::local.info_type')||
                                    old('calculate',$salaryComponent->calculate) == 'info_type' ? 'selected':'' }} value="info">{{ trans('staff::local.info_type') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>                        
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.formula') }}</label>
                            <textarea name="formula" class="form-control" cols="30" rows="5">{{old('formula',$salaryComponent->formula)}}</textarea>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="5">{{old('description',$salaryComponent->description)}}</textarea>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('salary-components.index')}}';">
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
