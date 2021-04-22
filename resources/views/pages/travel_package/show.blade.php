@extends('layouts.main2')

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

        <div class="container">
            <div class="page-travel_package-show__content">
                <div class="col-md-10 col-12 mx-auto no-gutters pl-0 pr-0">
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

                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection