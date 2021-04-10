@extends('layouts.main2')

@section('content')
    <div class="TravelOffersPage">
        <x-header backgroundImage="{{$backgroundImage}}">
            <div class="container TravelOffersPage__header-content">
                <h3 class="TravelOffersPage__header-content__heading">Reisipakkumised</h3>
            </div>
            <div class="container no-gutters TravelOffersPage__tags-container">
                <div class="row">
                    <div class="col-md-10 col-12 mx-auto">
                        <div class="TravelOffersPage__tags">
                            <div class="TravelOffersPage__tags__tag {{Route::currentRouteName() === 'travel_offer.travel_package.index' ? 'TravelOffersPage__tags__tag--active' : ''}}">
                                Reisipaketid
                            </div>
                            <div class="TravelOffersPage__tags__tag">
                                Ringreisid
                            </div>
                            <div class="TravelOffersPage__tags__tag">
                                Suusareisid
                            </div>
                            <div class="TravelOffersPage__tags__tag TravelOffersPage__tags__tag--last_minute">
                                Viimase hetke pakkumised
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-header>

        <div class="container">
            <div class="TravelOffersPage__content">
                <div class="row">
                    <div class="col-md-10 col-12 mx-auto">
                        <div class="TravelOffersPage__search">
                            <travel-package-search/>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-12 ml-0 pl-0 mr-0 pr-0">
                                @if (!$showList)
                                    <div class="TravelOffersPage__grid-wrapper">
                                        @foreach($items as $destinationId => $item)
                                            <x-travel-offer-card :offer="$item" />
                                        @endforeach
                                    </div>
                                @else
                                    <div class="TravelOffersPage__filter">
                                        <form-select
                                                name="filter"
                                                :options="{{json_encode($filters)}}"
                                                isclasses="TravelOffersPage__select"
                                                value="start"/>
                                    </div>

                                    @foreach($items as $item)
                                        <div class="TravelOfferListItem">
                                            <div class="TravelOfferListItem__content">
                                                <div class="TravelOfferListItem__title">
                                                    {{$item->name}} al. <span>{{$item->price}}€</span>
                                                </div>
                                                <div class="TravelOfferListItem__meta">
                                                    <div class="TravelOfferListItem__days">7 päeva</div>
                                                    <div class="TravelOfferListItem__tag">
                                                        <tag title="Antalya" isclasses="Tag--orange"/>
                                                    </div>
                                                    <div class="TravelOfferListItem__tag">
                                                        <tag title="TestFirma"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="Block ">
                                    <div class="Block__title">
                                        <div class="BlockTitle">
                                            <div>
                                                <div class="BlockTitle__title">Info</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Block__content">
                                        <div class="Block__contentItem">
                                            <div class="Body">Trip.ee ei ole reisipakettide edasimüüja, vaid ainult vahendab neid.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection