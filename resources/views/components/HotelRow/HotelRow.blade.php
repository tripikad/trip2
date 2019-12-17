@php


@endphp

<div class="HotelRow {{ $isclasses }}">

    <div class="HotelRow__nameAndDetails">

        <div class="HotelRow__name">

            {{ $hotel->name }}

        </div>

        <div class="HotelRow__details">

            <div class="HotelRow__rating">

                {{ $hotel->rating }}

            </div>

            <div class="HotelRow__type">

                {{ $hotel->type }}

            </div>

            <a class="HotelRow__url" href="{{ $hotel->url }} " target="_blank">{{ $hotel->urlTitle }}</a>

        </div>

    </div>

    <div class="HotelRow__price">

        {{ $hotel->price }}

    </div>

</div>