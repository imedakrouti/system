@extends('layouts.frontEnd.site')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mt-1">
      {{-- <h3 class="content-header-title">{{$title}}</h3> --}}
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item">
                <a href="{{route('all.products',$product->department->id)}}">
                    @if (session('lang') =='ar')
                        {{$product->department->ar_department_name}}
                    @else
                        {{$product->department->en_department_name}}
                    @endif
                </a>
            </li>
            <li class="breadcrumb-item active">
                @if (session('lang') =='ar')
                    {{$product->ar_product_name}}
                @else
                    {{$product->en_product_name}}
                @endif
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row product-continer product-continer-top mt-2">
    @include('layouts.frontEnd.pages._productImages')
    <div class="col-4 col-xs-12 product-inside">
        <h4 class="red">
            @if (session('lang') =='ar')
                {{$product->ar_product_name}}
            @else
                {{$product->en_product_name}}
            @endif
        </h4>
        <h3 class="blue mt-2 mb-2"><strong>{{$product->price}} {{$product->country->currency}}</strong></h3>
        <h6>{{ trans('admin.tax_note') }} <a href="#">{{ trans('admin.details') }}</a></h6>
        <p>{{$product->ar_description}}</p>

    </div>
    <div class="col-3 col-xs-12 product-inside">
        <p class="product-ship-tip">{{$product->note}}</p>
        <a href="{{route('cart.add',$product->id)}}"  class="btn btn-dark round btn-min-width mr-1 mb-1">{{ trans('admin.add_cart') }}</a>
        <hr>
        <h6><strong>{{ trans('admin.item_condition')}} :</strong> {{$product->item_condition}}</h6>
        <h6><strong>{{ trans('admin.seller')}} :</strong> {{$product->seller->seller_name}}</h6>
    </div>
</div>
<div class="row product-continer mt-2" style="min-height: 200px">
    <div class="col-12 col-lg-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <ul class="nav nav-tabs nav-underline no-hover-bg">
              <li class="nav-item">
                <a class="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31"
                href="#tab31" aria-expanded="true">{{session('lang') =='ar' ? trans('admin.ar_description'):trans('admin.en_description')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="base-tab33" data-toggle="tab" aria-controls="tab33" href="#tab33"
                aria-expanded="false">تقييمات</a>
              </li>
            </ul>
            <div class="tab-content px-1 pt-1">
              <div role="tabpanel" class="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
                  <table>
                        @foreach ($product->productSpecifications as $item)
                            <tr><th class="w-50">{{session('lang') =='ar'?$item->specification->ar_specification_name:$item->specification->en_specification_name}}</th>
                                <td class="pl-1">{{session('lang') =='ar' ?$item->definition->ar_value:$item->definition->en_value}}</td>
                            </tr>
                        @endforeach
                  </table>
              </div>
              <div class="tab-pane" id="tab33" aria-labelledby="base-tab33">
                <p>Biscuit ice cream halvah candy canes bear claw ice cream
                  cake chocolate bar donut. Toffee cotton candy liquorice.
                  Oat cake lemon drops gingerbread dessert caramels. Sweet
                  dessert jujubes powder sweet sesame snaps.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

