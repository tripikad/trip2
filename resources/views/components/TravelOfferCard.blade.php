<div class="col-xs-6 col-md-6 col-lg-6 col-12 pb-4 TravelOfferCard">
    <a href="{{ request()->fullUrlWithQuery(['destination' => $offer->parentDestinationId]) }}">
        <div class="TravelOfferCard__item">
            <div class="TravelOfferCard__item__bg" style="background-image: linear-gradient(
                    rgba(0, 0, 0, 0.3),
                    rgba(0, 0, 0, 0.1),
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.4)), url({{asset('photos/destination/greece.jpg')}});">
            </div>
            <div class="TravelOfferCard__item__destination">
                {{$offer->parentDestinationName}}
            </div>
            <div class="TravelOfferCard__item__price">
                al. <span>{{$offer->price}}€</span>
            </div>
        </div>
    </a>
</div>