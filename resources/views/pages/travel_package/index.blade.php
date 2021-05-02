@extends('layouts.main2')

@section('head_title')
    Reisipakkumised
@endsection
@section('head_description')
    Reisipakkumised
@endsection
@section('head_image')
    {{$backgroundImage}}
@endsection

@section('content')
    <div class="TravelOffersPage">
        <x-header backgroundImage="{{$backgroundImage}}">
            <div class="container TravelOffersPage__header-content">
                <h3 class="TravelOffersPage__header-content__heading">Reisipakkumised</h3>
            </div>
            <div class="container no-gutters TravelOffersPage__tags-container">
                <div class="row">
                    <div class="col-md-11 col-12 mx-auto">
                        <div class="TravelOffersPage__tags">
                            <a href="{{route('travel_offer.travel_package.index')}}" class="TravelOffersPage__tags__tag {{Route::currentRouteName() === 'travel_offer.travel_package.index' ? 'TravelOffersPage__tags__tag--active' : ''}}">
                                <span>Reisipaketid</span>
                            </a>
                            <a href="#" class="TravelOffersPage__tags__tag">
                                <span>Ringreisid</span>
                            </a>
                            <a href="#" class="TravelOffersPage__tags__tag">
                                <span>Suusareisid</span>
                            </a>
                            <a href="#" class="TravelOffersPage__tags__tag TravelOffersPage__tags__tag--last_minute">
                                <span>Viimase hetke pakkumised</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </x-header>

        <div class="container">
            <div class="TravelOffersPage__content">
                <div class="row">
                    <div class="col-md-11 col-12 mx-auto">
                        <div class="TravelOffersPage__search {{!$showList ? 'TravelOffersPage__search__grid_view' : ''}}">
                            <travel-package-search
                                    :start-destinations="{{json_encode($startDestinations)}}"
                                    :end-destinations="{{json_encode($endDestinations)}}"
                                    :nights="{{json_encode($nights)}}"
                                    :selected-start-destination="{{$selectedStartDestination}}"
                                    selected-end-destination="{{$selectedEndDestination}}"
                                    selected-start-date="{{$selectedStartDate}}"
                                    selected-nights="{{$selectedNights}}"
                            />
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-12 {{!$showList ? 'ml-0 pl-0' : ''}}">
                                @if (!$showList)
                                    <div class="TravelOffersPage__grid-wrapper">
                                        @foreach($items as $destinationId => $item)
                                            <x-travel-offer-card :offer="$item" />
                                        @endforeach
                                    </div>
                                @else
                                    @if ($items && count($items))
                                        <div class="TravelOffersPage__filter">
                                            <form-select
                                                    name="filter"
                                                    :options="{{json_encode($filters)}}"
                                                    isclasses="TravelOffersPage__select"
                                                    value="start"/>
                                        </div>

                                        @foreach($items as $item)
                                            <x-travel-offer-list-item :offer="$item" class="TravelOffersPage__list_item"/>
                                        @endforeach
                                    @else
                                        <div>
                                            Ei leitud ühtegi vastet (TODO)
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-3 col-12 {{$showList ? 'mt-2' : ''}}">
                                <div class="Block TravelOffersPage__info_block Block--gray">
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

                                <div class="Block Block--gray TravelOffersPage__info_block">
                                    <div class="Block__title">
                                        <div class="BlockTitle">
                                            <div>
                                                <div class="BlockTitle__title">Lisa enda kuulutus</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Block__content">
                                        <div class="Block__contentItem">
                                            <div class="Body">
                                                Enda kuulutuse lisamiseks kliki <a href="{{Auth::user() && Auth::user()->company_id ? route('company.profile', ['company' => Auth::user()->company_id]) : route('register_company.form')}}">siia</a> või võta ühendust<br>
                                                <a href="mailto:reisipakkumised@trip.ee">reisipakkumised@trip.ee</a>
                                            </div>
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