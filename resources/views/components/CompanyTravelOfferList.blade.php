<div class="CompanyTravelOfferList">
    @foreach($travelOffers as $offer)
        <div class="CompanyTravelOfferList__item_wrapper">
            <div class="CompanyTravelOfferList__item">
                <x-travel-offer-list-item :offer="$offer"/>
            </div>
            <div class="CompanyTravelOfferList__stats">
                <div class="CompanyTravelOfferList__stats__content">
                    <div class="CompanyTravelOfferList__meta_row">Vaatamisi: {{$offer->views ? $offer->views->count : 0}}</div>
                    <div class="CompanyTravelOfferList__meta_row">Päringuid: 0</div>
                </div>
                <div class="CompanyTravelOfferList__buttons">
                    <div class="TravelOfferListItem__button">
                        <a href="{{route('company.edit_travel_offer', ['company' => $company, 'travelOffer' => $offer])}}" class="Button Button--small Button--blue">
                            Muuda
                        </a>
                    </div>
                    <div class="TravelOfferListItem__button">
                        <div class="Button Button--small Button--pink">
                            <form action="{{route('company.delete_travel_offer', ['company' => $company, 'travelOffer' => $offer])}}" method="POST">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="Form__field">
                                    <input type="submit" value="Kustuta" class="FormLink FormLink--pink">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="CompanyTravelOfferList__paginator">
        {!! $paginator !!}
    </div>
</div>