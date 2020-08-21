@extends('layouts.frontEnd.site')
@section('content')

@include('layouts.frontEnd.pages._dashboard._specialOffer')

@foreach ($categories as $category)
    @if ($category->show == trans('admin.yes'))
    <div class="row">
        <div class="col-12">
            <div class="dashboard-border">
                <h4 class="card-title">{{$category->ar_category_name}}</h4>
                <div class="row">
                    @foreach ($category->departments as $department)
                        <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                            <a href="{{route('all.products',$department->id)}}" itemprop="contentUrl" data-size="480x360">
                            <img class="img-thumbnail img-fluid product-dash-image" src="{{asset('/images/department_images\/').$department->department_image}}"
                            itemprop="thumbnail" alt="Image description" />
                            </a>
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @endif
@endforeach

@include('layouts.frontEnd.pages._dashboard._buyNow')

@include('layouts.frontEnd.pages._dashboard._offer')

@endsection
