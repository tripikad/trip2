<div {{ $attributes->merge(['class' => 'TravelOfferListItem']) }}>
    <div class="TravelOfferListItem__content">
        <div class="TravelOfferListItem__title">
            <a href="{{route('travel_offer.travel_package.show', ['slug' => $offer->slug])}}">
                {{$offer->name}} <span class="from">al. </span><span class="price">{{$offer->price}}€</span>
            </a>
        </div>
        <div class="TravelOfferListItem__meta">
            <div class="TravelOfferListItem__days">{{$offer->nights}} ööd</div>
            <div class="TravelOfferListItem__tag">
                <tag title="{{$offer->endDestination->name}}" isclasses="Tag--orange"/>
            </div>
            <div class="TravelOfferListItem__tag">
                <tag title="{{$offer->endDestination->parent->name}}" isclasses="Tag--orange"/>
            </div>
            <div class="TravelOfferListItem__tag">
                <tag title="{{$offer->company->name}}" route="{{route('company.profile.public', ['slug' => $offer->company->slug])}}"/>
            </div>
        </div>
    </div>
</div>