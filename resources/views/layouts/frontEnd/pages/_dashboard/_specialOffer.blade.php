@if (count($offers) > 0)
<div class="row">
    <div class="col-12 mt-2">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner" role="listbox">
                @foreach ($offers as $offer)
                <div class="carousel-item {{$offer->start_offer}}">
                    <a href="{{$offer->link}}"><img width="100%" src="{{asset('/images/offers\/').$offer->image_offer_name}}" alt="Second slide"></a>
                  </div>
                @endforeach

            </div>
            <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
@endif

