@extends('layouts.companyProfileLayout')

@section('body')
    <company-travel-offers-page :company="{{json_encode($company)}}"/>
@endsection