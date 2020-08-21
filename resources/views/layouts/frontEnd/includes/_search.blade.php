<div class="row">
    <div class="col-md-12">

        <fieldset>
            <form action="{{route('product.search',$products->count() > 0 ?$products[0]->department->id : 0)}}" method="get" id="formSearch">
                <div class="input-group">
                    <input type="text" class="form-control input-lg" placeholder="{{ trans('admin.search_product') }}"
                    aria-describedby="button-addon2" id="searchBox" name="searchBox">
                    @csrf
                    <div id="dataList"></div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="la la-search"></i></button>
                    </div>
                </div>
            </form>

          </fieldset>
    </div>
</div>
