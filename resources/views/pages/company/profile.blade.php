@extends('layouts.companyProfileLayout')

@section('body')
    <div class="row page-company-travel-offers mr-0 ml-0">
        <div class="col-md-8 col-12">
            <company-travel-offer-list :items="{{json_encode($company->travelOffers)}}"/>
        </div>
        <div class="col-md-4 col-12 mt-5 mt-md-0">
            <div>
                <travel-offer-add-new-select :company-id="{{$company->id}}"/>
            </div>
            <div class="page-company-travel-offers__subscription">
                <travel-offer-subscription-plan/>
            </div>
        </div>
    </div>
@endsection