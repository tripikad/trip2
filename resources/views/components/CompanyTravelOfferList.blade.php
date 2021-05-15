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
                        <button-vue title="Muuda"
                                    isclasses="Button--small Button--blue"
                                    route="#"
                        />
                    </div>
                    <div class="TravelOfferListItem__button">
                        <button-vue title="Kustuta"
                                    isclasses="Button--small Button--pink"
                                    route="#"
                        />
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="CompanyTravelOfferList__paginator">
        {!! $paginator !!}
    </div>
</div>