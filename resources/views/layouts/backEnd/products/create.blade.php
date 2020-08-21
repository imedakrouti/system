@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('products.index')}}">{{ trans('admin.products') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('products.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('admin.ar_product_name') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_product_name')}}" placeholder="{{ trans('admin.ar_product_name') }}"
                                name="ar_product_name">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('admin.en_product_name') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('en_product_name')}}" placeholder="{{ trans('admin.en_product_name') }}"
                                name="en_product_name">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('admin.ar_description') }}</label>
                              <div class="col-md-9">
                                <textarea class="form-control" name="ar_description" id="" cols="30" rows="5">{{old('ar_description')}}</textarea>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('admin.en_description') }}</label>
                              <div class="col-md-9">
                                <textarea class="form-control" name="en_description" id="" cols="30" rows="5">{{old('en_description')}}</textarea>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                              <label class="col-md-3 label-control">{{ trans('admin.department') }}</label>
                              <div class="col-md-9">
                                <select name="department_id" id="department_id" class="form-control" disabled>
                                </select>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('admin.provenance') }}</label>
                            <div class="col-md-9">
                                <select name="country_id" id="country_id" class="form-control">
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 label-control" >{{ trans('admin.item_condition') }}</label>
                            <div class="col-md-9">
                                <select name="item_condition" class="form-control">
                                    <option>{{ trans('admin.select') }}</option>
                                    <option {{ (old('item_condition') == 'new')?'selected':''}} value="new">{{ trans('admin.new') }}</option>
                                    <option {{ (old('item_condition') == 'used')?'selected':''}} value="used">{{ trans('admin.used') }}</option>
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('admin.price') }}</label>
                              <div class="col-md-9">
                                <input type="text"  class="form-control " value="{{old('price')}}" placeholder="{{ trans('admin.price') }}"
                                  name="price">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('admin.discount_price') }}</label>
                              <div class="col-md-9">
                                <input type="text"  class="form-control " value="{{old('discount_price')}}" placeholder="{{ trans('admin.discount_price') }}"
                                  name="discount_price">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('admin.sellerName') }}</label>
                              <div class="col-md-9">
                                <select name="seller_id" id="seller_id" class="form-control">
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 label-control">{{ trans('admin.note') }}</label>
                            <div class="col-md-9">
                                <textarea name="note" class="form-control cols="30" rows="2">{{old('note')}}</textarea>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('admin.brand') }}</label>
                              <div class="col-md-9">
                                <input type="text"  class="form-control " value="{{old('brand')}}" placeholder="{{ trans('admin.brand') }}"
                                  name="brand">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control" >{{ trans('admin.product_image') }}</label>
                              <div class="col-md-9">
                                <input  type="file" name="product_image"/>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" id="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('products.index')}}';">
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
        (function getSellers()
	    {
	        $.ajax({
	          type:'ajax',
	          method:'get',
	          url:'{{route("get.sellers")}}',
	          dataType:'json',
	          success:function(data){
	            $('#seller_id').html(data);
	          }
	        });
		}());
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
        (function getCountries()
	    {
	        $.ajax({
	          type:'ajax',
	          method:'get',
	          url:'{{route("get.countries")}}',
	          dataType:'json',
	          success:function(data){
	            $('#country_id').html(data);
	          }
	        });
		}());
		$('#category_id').on('change',function(){
			var category_id = $(this).val();  //set country = country_id
			if (category_id == '') // is empty
			{
				$('#department_id').prop('disabled', true); // set disable
			}
			else // is not empty
			{
				$('#department_id').prop('disabled', false);	// set enable
				//using
				$.ajax({
					url:'{{route("get.departments.id")}}',
					type:"post",
					data: {
						_method		: 'PUT',
						category_id 	: category_id,
						_token		: '{{ csrf_token() }}'
						},
					dataType: 'json',
					success: function(data){
						$('#department_id').html(data);
					}
				});
			}
		})
</script>
@endsection

