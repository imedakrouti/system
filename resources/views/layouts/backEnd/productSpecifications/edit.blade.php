@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('productSpecifications.index')}}">{{ trans('admin.productSpecifications') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('productSpecifications.update',$productSpecifications->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')

                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('productSpecifications.index')}}';">
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
	    (function getSpecificationSelected()
	    {
			 var specification_id = "{{ $productSpecifications->specification_id }}";
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
