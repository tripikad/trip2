@extends('layouts.main2')

@section('content')
    <div class="page-company-profile">
        <div class="page-company-profile__header">
            <div class="container-lg">
                <div class="page-company-profile__navigation">
                    <x-navbar/>
                </div>
                <div class="page-company-profile__heading pb-4">
                    <h3>{{$company->name}}</h3>
                </div>
            </div>
        </div>

        <div class="container page-company-profile__content">
            Content
        </div>

        <x-footer/>
    </div>
@endsection