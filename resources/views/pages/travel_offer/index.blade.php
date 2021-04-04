@extends('layouts.main2')

@section('content')
    <div class="TravelOffersPage">
        <x-header class="TravelOffersPage__header" backgroundImage="{{asset('photos/pic5.jpg')}}">
            <div class="container TravelOffersPage__header-content">
                <h3 class="TravelOffersPage__header-content__heading">Reisipakkumised</h3>
            </div>
            <div class="container no-gutters TravelOffersPage__header__tags">
                <div class="row">
                    <div class="col-md-10 col-12 mx-auto">
                        <div class="TravelOfferSearch__tags">
                            <div class="TravelOfferSearch__tag TravelOfferSearch__tag--active">
                                Reisipaketid
                            </div>
<!--                            <div class="TravelOfferSearch__tag">
                                Ringreisid
                            </div>
                            <div class="TravelOfferSearch__tag">
                                Suusareisid
                            </div>-->
<!--                            <div class="TravelOfferSearch__tag TravelOfferSearch__last_minute">
                                Viimase hetke pakkumised
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </x-header>

        <div class="container">
            <div class="row TravelOffersPage__content">
                <div class="col-md-10 col-12 mx-auto">
                    <div class="TravelOffersPage__search">
                        <travel-offer-search/>
                    </div>

                    @if (!$showList)
                        <div class="row no-gutters2 TravelOffersPage__grid-wrapper">
                            @foreach($items as $destinationId => $item)
                                <div class="col-xs-6 col-md-6 col-lg-4 col-12 pb-4">
                                    <a href="{{ request()->fullUrlWithQuery(['destination' => $destinationId]) }} ">
                                    <div class="TravelOffersPage__item">
                                        <div class="TravelOffersPage__item__bg" style="background-image: linear-gradient(
                                                rgba(0, 0, 0, 0.3),
                                                rgba(0, 0, 0, 0.1),
                                                rgba(0, 0, 0, 0.2),
                                                rgba(0, 0, 0, 0.4)), url({{asset('photos/destination/greece.jpg')}});">
                                        </div>
                                        <div class="TravelOffersPage__item__destination">
                                            {{$item['name']}}
                                        </div>
                                        <div class="TravelOffersPage__item__price">
                                            al. <span>{{$item['price']}}€</span>
                                        </div>
                                    </div>
                                    </a>
                                </div>
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
            </div>
<!--            <travel-offer />-->
        </div>

        <x-footer/>
    </div>
@endsection