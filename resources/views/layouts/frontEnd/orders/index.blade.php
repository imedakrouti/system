@extends('layouts.frontEnd.site')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mt-1">
      {{-- <h3 class="content-header-title">{{$title}}</h3> --}}
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-3">
        <div class="card-content collapse show">
            <div class="card-body">
              <div class="list-group">
                <a href="{{route('user.orders')}}" class="list-group-item {{request()->segment(2)=='orders'?'active':''}}">{{ trans('admin.myPurchases') }}</a>
                <a href="{{route('user.orders')}}" class="list-group-item {{request()->segment(2)=='orders'?'actsive':''}}">عناويني</a>
                <a href="{{route('user.orders')}}" class="list-group-item {{request()->segment(2)=='orders'?'actsive':''}}">القوائم المفضلة</a>
                <a href="{{route('user.orders')}}" class="list-group-item {{request()->segment(2)=='orders'?'actsive':''}}">إعدادات الحساب</a>
              </div>
            </div>
          </div>
    </div>
    <div class="col-md-9">
        @if (count($purchases) > 0)
            @foreach ($purchases as $purchase)
            <div class="card">
                @foreach ($purchase->items as $product)
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
                                <h6 class="mt-1"><strong>{{ trans('admin.count') }}</strong> :
                                <input type="number" disabled style="width: 70px; display:inline-block" min="1" id="qty" class="form-control" value="{{$product['qty']}}"></h6>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                        <h3 class="ml-1 card-title">{{ trans('admin.date_purchases') }} : <strong>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($purchase->created_at))->diffForHumans()}}</strong></h3>
                        <h3 class="ml-1 card-title">{{ trans('admin.total') }} : <strong>{{$purchase->totalPrice}}</strong> جنيه</h3>
                    </div>
            @endforeach

        @else
                <h3>{{ trans('admin.no_purchases') }}</h3>
        @endif

    </div>
</div>
{{$orders->links()}}
@endsection
