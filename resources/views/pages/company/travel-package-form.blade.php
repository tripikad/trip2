@extends('layouts.main2')

@section('content')

    <div class="company-edit-profile">

        <div class="container">
            <div class="company-edit-profile__navigation">
                <x-navbar/>
            </div>

            <h2 class="company-edit-profile__header">
                {{$title}}
            </h2>

            <travel-offer-package-form
                submit-route="{{$submitRoute}}"
                add="{{$offer ? false : true}}"
                back-route="{{route('company.profile', ['company' => $company])}}"
                :destination-options="{{json_encode($destinationOptions) }}"
                :accommodation-options="{{json_encode($accommodationOptions) }}"
                destination="{{old('destination', $offer ? $offer->destination_id : null)}}"
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