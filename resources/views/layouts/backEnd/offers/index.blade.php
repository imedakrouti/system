@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
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
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <a href="{{route('offers.create')}}" class="btn btn-success buttons-print btn-success mb-1 mt-3">{{ trans('admin.add_offer') }}</a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
                <div class="row">
                    @foreach ($offers as $offer)
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                            <div class="card-content">
                                <a href="{{$offer->link}}"><img class="card-img-top img-fluid" src="{{asset('/images/offers\/').$offer->image_offer_name}}"
                                alt="Card image cap"></a>
                                <div class="card-body">
                                <h4 class="card-title">{{$offer->title}}</h4>
                                <p>
                                    <strong>{{ trans('admin.start_time') }}</strong> : {{$offer->start_display}} <br>
                                    <strong>{{ trans('admin.end_time') }}</strong> : {{$offer->end_display}}
                                </p>

                                <form action="{{route('offers.destroy',$offer->id)}}" method="post" id="formData">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{$offer->link}}" class="btn btn-info btn-sm ">{{ trans('admin.offer') }}</a>
                                    <a href="{{route('offers.edit',$offer->id)}}"class="btn btn-warning btn-sm ">{{ trans('admin.editing') }}</a>
                                    <button id="btnDelete" type="submit" class="btn btn-danger btn-sm ">{{ trans('admin.delete') }}</button>
                                </form>

                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{$offers->links()}}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script>
   $("form").submit(function(e){
        event.preventDefault();
        swal({
            title: "{{trans('msg.delete_confirmation')}}",
            text: "{{trans('admin.delete_offer_ask')}}",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "{{trans('msg.yes')}}",
            cancelButtonText: "{{trans('msg.no')}}",
            closeOnConfirm: false
            },
            function(){
                $("#formData").submit();
        });
        
    });
</script>
@endsection
