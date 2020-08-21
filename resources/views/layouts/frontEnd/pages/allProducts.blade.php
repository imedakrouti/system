@extends('layouts.frontEnd.site')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mt-1">
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item">
                @if (count($products) > 0)
                    <a href="{{route('all.products',$products[0]->department->id)}}">
                        @if (session('lang') =='ar')
                            {{$products[0]->department->ar_department_name}}
                        @else
                            {{$products[0]->department->en_department_name}}
                        @endif
                    </a>
                @endif
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-3" >
        <div class="col-md-12 col-sm-12">
            <div style="min-height: 700px;">
                  <div class="row mb-1">
                    <div class="col-md-12 col-sm-12">
                        @if (count($definitions) > 0)
                            <form action="{{route('products.filter',$definitions[0]->department->id)}}" method="get" id="formProducts">
                                @foreach ($specifications as $specification)
                                <h5><strong>{{session('lang') == 'ar'?$specification->ar_specification_name:$specification->en_specification_name}}</strong></h5>
                                {{-- <div id="basic-list"> --}}
                                    {{-- <input type="text" class="search form-control mb-1 mt-1" placeholder="{{$specification->ar_specification_name}}"/> --}}
                                    <ul class="list-group list ">
                                        @if (session('lang') == 'ar')
                                            @foreach ($specification->definitions as $item)
                                                    @foreach ($definitions as $definition)
                                                            @if ($item->id == $definition->id)
                                                                <li class="list-group-item product-list-group-item ">
                                                                    <div class=" name filter">
                                                                        <input type="checkbox"
                                                                        {{session()->has('filter') ? in_array($item->ar_value,session('filter')) ? 'checked' : '' : ''}}
                                                                        name="{{$definition->id}}" value="{{$item->ar_value}}"> {{$item->ar_value}}
                                                                    </div>
                                                                </li>
                                                            @endif
                                                    @endforeach
                                            @endforeach
                                        {{-- english lang --}}
                                        @else
                                            @foreach ($specification->definitions as $item)
                                                @foreach ($definitions as $definition)
                                                        @if ($item->id == $definition->id)
                                                            <li class="list-group-item product-list-group-item ">
                                                                <div class=" name filter">
                                                                    <input type="checkbox"
                                                                    {{session()->has('filter') ? in_array($item->en_value,session('filter')) ? 'checked' : '' : ''}}
                                                                    name="{{$definition->id}}" value="{{$item->en_value}}"> {{$item->en_value}}
                                                                </div>
                                                            </li>
                                                        @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </ul>
                                {{-- </div> --}}
                                <hr>
                                @endforeach
                            </form>
                        @else
                            <h5 class="red">{{ trans('admin.no_departments') }}</h5>
                        @endif

                    </div>
                  </div>
            </div>
          </div>
    </div>
    <div class="col-md-9">
        <div class="card" style="min-height: 700px;">
            <div class="row">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <div class="col-xl-4 col-md-6 col-sm-4" >
                            <div class="all-products-item">
                                <a href="{{route('product',$product->id)}}">
                                    <img style="width: 300px; height:300px" class="card-img-top img-fluid" src="{{asset('images/product_images/'.$product->product_image)}}">
                                </a>
                                <div class="card-body">
                                    <p style="min-height: 80px" class="card-text">{{$product->ar_product_name}}</p>
                                    <h4 class="center up">{{$product->brand}}</h4>
                                    <h3 class="blue center up"><strong>{{$product->price}} {{$product->country->currency}}</strong></h3>
                                </div>
                                <div class="center">
                                    <a href="{{route('cart.add',$product->id)}}" class="btn btn-warning btn-md mb-1 btn-add-cart">{{ trans('admin.add_cart') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                        <div class="col-xl-12 mt-2 ml-2" >
                            <h3 class="red">{{ trans('admin.no_products') }}</h3>
                        </div>
                @endif

            </div>
        </div>
        {{$products->links()}}
    </div>
</div>

@endsection
@section('script')
    <script>
        // filter
        $(".filter").change(function() {
            $('#formProducts').submit();
        });
    </script>
    <script src="{{asset('cpanel/app-assets/vendors/js/extensions/listjs/list.min.js')}}"></script>
    <script src="{{asset('cpanel/app-assets/js/scripts/extensions/list.js')}}"></script>
@endsection


