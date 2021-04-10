@extends('layouts.main2')

@section('content')
    <div class="page-travel-package-form">
        <div class="container">
            <div class="page-travel-package-form__navigation">
                <x-navbar/>
            </div>

            <h2 class="page-travel-package-form__header">
                {{$title}}
            </h2>

            <travel-package-form
                    submit-route="{{$submitRoute}}"
                    add="{{$offer ? false : true}}"
                    back-route="{{route('company.profile', ['company' => $company])}}"
                    :destination-options="{{json_encode($destinationOptions) }}"
                    :accommodation-options="{{json_encode($accommodationOptions) }}"
                    start-destination="{{old('start_destination', $offer ? $offer->startDestination->id : null)}}"
                    end-destination="{{old('end_destination', $offer ? $offer->endDestination->id : null)}}"
                    start-date="{{old('start_date', $offer ? $offer->start_date->format('Y-m-d') : null)}}"
                    end-date="{{old('end_date', $offer ? $offer->end_date->format('Y-m-d') : null)}}"
                    description="{{old('description', $offer ? $offer->description : null)}}"
                    accommodation="{{old('accommodation', $offer ? $offer->accommodation : null)}}"
                    included="{{old('included', $offer ? $offer->included : null)}}"
                    excluded="{{old('excluded', $offer ? $offer->excluded : null)}}"
                    extra_fee="{{old('extra_fee', $offer ? $offer->extra_fee : null)}}"
                    :hotels="{{json_encode($hotels)}}"
                    :errors="{{$errors ? json_encode($errors->messages(), JSON_HEX_APOS) : []}}"
            />
        </div>

        <x-footer type="light"/>
    </div>
@endsection