@extends('layouts.main2')

@section('content')

    <div class="company-edit-profile">
        <x-body-background-map/>

        <div class="container">
            <div class="company-edit-profile__navigation">
                <x-navbar/>
            </div>

            <h2 class="company-edit-profile__header">
                {{$title}}
            </h2>

            <div class="company-edit-profile__form-container">
                <div class="company-edit-profile__form-container__form">

                    <vacation-package-form
                            add="{{!$package}}"
                            submit-route="{{$submitRoute}}"
                            :category-options="{{json_encode($categoryOptions)}}"
                            package-name="{{$package ? $package->name : ''}}"
                            start-date="{{$package ? $package->start_date : ''}}"
                            end-date="{{$package ? $package->end_date : ''}}"
                            price="{{$package ? $package->price : ''}}"
                            description="{{$package ? $package->description : ''}}"
                            link="{{$package ? $package->link : ''}}"
                            :category="{{$package ? json_encode($package->vacationPackageCategories->pluck('id')) : '[]'}}"/>
                </div>
            </div>
        </div>

        <x-footer type="light"/>
    </div>
@endsection