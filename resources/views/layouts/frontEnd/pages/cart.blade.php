@extends('layouts.frontEnd.site')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mt-1">
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item">
                {{ trans('admin.cart') }} ({{session()->has('cart')?session('cart')->totalQty:0}})
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-8">
        @if($errors->any())
            @foreach($errors->all() as $error)
            <!-- print all errors -->
                <h4 class="red">
                    {{$error}}
                </h4>
            @endforeach
        @endif
        @if(session()->has('cart'))
            @foreach ($cart->items as $product)
                <div class="card">
                    <div class="row">
                        <div class="col-md-2">
                            <img class="mt-1" width="100" height="100" src="{{asset('images/product_images/'.$product['image'])}}" alt="">
                        </div>
                        <div class="col-md-10">
                            <h5 class="mt-1">{{$product['item']}}</h5>
                            <h4 class="mt-1 blue"><strong>{{$product['price']}} جنيه</strong></h4>
                            <h6 class="mt-1"><strong>{{ trans('admin.brand') }}</strong> : {{$product['brand']}}</h6>
                            <h6 class="mt-1"><strong>{{ trans('admin.item_condition') }}</strong> : {{$product['item_condition']}}</h6>
                            <h6 class="mt-1"><strong>{{ trans('admin.note') }}</strong> : {{$product['note']}}</h6>

                            <form action="{{route('cart.update',[$product['id']])}}" method="post" class="formData" style="display: inline-block">
                                @csrf
                                @method('PUT')
                                <h6 style="display: inline-block" class="mt-1"><strong>{{ trans('admin.count') }}</strong> :</h6>
                                <input style="width: 70px; display:inline" name="qty" class="form-control qty" value="{{$product['qty']}}">
                                <button type="submit" class="btn btn-default btn-sm"><i class="la la-refresh"></i></button>
                            </form>
                            <hr>
                            <div class="mb-1">
                            <form action="{{route('cart.remove',$product['id'])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="qty" class="btn btn-danger"><i class="la la-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h3 class="red">{{ trans('admin.empty_car') }}</h3>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="col-md-12">
                <h6 class="mt-1"><strong>{{ trans('admin.total') }}</strong></h6>
                <h2 class="mt-1"><strong>{{ $cart->totalPrice }} جنيه</strong></h2>
                <hr>
                <div class="mb-1 center">
                    <a style="display: inline-block" href="{{route('home')}}" class="btn btn-info">{{ trans('admin.continue_shopping') }}</a>
                    <a style="display: inline-block" href="{{route('cart.checkout',$cart->totalPrice)}}" class="btn btn-success">{{ trans('admin.buy') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

