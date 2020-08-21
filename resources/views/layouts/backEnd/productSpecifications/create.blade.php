@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('productSpecifications.index',$id)}}">{{ trans('admin.productSpecifications') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('productSpecifications.store')}}">
                @csrf
                <div class="form-body">
                    <h1 class="card-title"><strong>{{$productName}}</strong></h1>
                    <hr>
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <input type="hidden" name="product_id" value="{{$id}}">
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.specifications') }}</label>
                          <div class="col-md-9">
                            <select name="specification_id" id="specification_id" class="form-control">
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.definitions') }}</label>
                          <div class="col-md-9">
                            <select name="definition_id" id="definition_id" class="form-control" disabled>
                            </select>
                          </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('productSpecifications.index',$id)}}';">
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
    	(function getSpecifications()
	    {
	        $.ajax({
	          type:'ajax',
	          method:'get',
	          url:'{{route("get.specifications")}}',
	          dataType:'json',
	          success:function(data){
	            $('#specification_id').html(data);
	          }
	        });
		}());
		$('#specification_id').on('change',function(){
			var specification_id = $(this).val();  //set country = country_id
			if (specification_id == '') // is empty
			{
				$('#definition_id').prop('disabled', true); // set disable
			}
			else // is not empty
			{
				$('#definition_id').prop('disabled', false);	// set enable
				//using
				$.ajax({
					url:'{{route("get.definitions")}}',
					type:"post",
					data: {
						_method		        : 'PUT',
						specification_id 	: specification_id,
						_token		        : '{{ csrf_token() }}'
						},
					dataType: 'json',
					success: function(data){
						$('#definition_id').html(data);
					}
				});
			}
		})
</script>
@endsection
