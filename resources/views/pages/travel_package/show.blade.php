@extends('layouts.main2')

@section('head_title')
    {{$offer->name . ' | Reisipakett'}}
@endsection
@section('head_description'){{$offer->name}}@endsection
@section('head_image'){{$backgroundImage}}@endsection

@push('styles')
    <style>
        .page-travel_package-show__background-image {
            background-image: linear-gradient(
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.4),
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.1)),
            url({{$backgroundImage}})!important;
        }
    </style>
@endpush

@section('content')
    <div class="page-travel_package-show">
        <x-header class="page-travel_package-show__header page-travel_package-show__background-image">
            <h3>{{$offer->name}}</h3>
            <div class="page-travel_package-show__header__tag_container">
                <tag title="Reisipakett" isclasses="Tag--white page-travel_package-show__header__tag"/>
            </div>
        </x-header>

        <div class="container-lg">
            <div class="page-travel_package-show__content">
                <div class="col-lg-10 col-md-12 col-12 mx-auto no-gutters pl-0 pr-0">
                    <div class="page-travel_package-show__info">
                        <div class="page-travel_package-show__info_block">
                            <svg class="page-travel_package-show__cal_svg"><use xlink:href="#calendar-alt"></use></svg>
                            <div class="page-travel_package-show__info_block__time">
                                <span>{{$offer->start_date->format('m.d')}} - {{$offer->end_date->format('m.d.Y')}}</span>
<!--                                <span class="page-travel_package-show__info_block__nights">7 ööd</span>-->
                            </div>
                        </div>
                        <div class="page-travel_package-show__info_block page-travel_package-show__info_block--with_border">
                            <a href="https://maps.google.com/?q={{urlencode($offer->destinationName . ',' . $offer->parentDestinationName)}}" target="_blank">
                                <svg><use xlink:href="#icon-pin"></use></svg>
                                <span>{{$offer->destinationName . ', ' . $offer->parentDestinationName}}</span>
                            </a>
                        </div>
                        <div class="page-travel_package-show__info_block">
                            <svg><use xlink:href="#icon-tickets"></use></svg>
                            <div>al. <span class="page-travel_package-show__info_block__price">{{$offer->price}}€</span></div>
                        </div>
                    </div>

                    <div class="page-travel_package-show__hotels">
                        <travel-package-hotel-selection
                                :offer="{{json_encode($offer)}}"
                                :hotels="{{json_encode($offer->hotels)}}"/>
                    </div>

                    @if ($offer->included)
                        <div class="page-travel_package-show__section">
                            <h3>Pakkumine sisaldab:</h3>
                            <div class="page-travel_package-show__section__content">
                                {!! $offer->included !!}
                            </div>
                        </div>
                    @endif

                    @if ($offer->excluded)
                        <div class="page-travel_package-show__section">
                            <h3>Pakkumine ei sisalda:</h3>
                            <div class="page-travel_package-show__section__content">
                                {!! $offer->excluded !!}
                            </div>
                        </div>
                    @endif

                    @if ($offer->extra_fee)
                        <div class="page-travel_package-show__section">
                            <h3>Lisatasu eest:</h3>
                            <div class="page-travel_package-show__section__content">
                                {!! $offer->extra_fee !!}
                            </div>
                        </div>
                    @endif

                    @if ($offer->extra_info)
                        <div class="page-travel_package-show__section">
                            <h3>Lisainfo:</h3>
                            <div class="page-travel_package-show__section__content">
                                {!! $offer->extra_info !!}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection