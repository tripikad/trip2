@extends('layouts.main2')

@push('styles')
    <style>
        .vp-background-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.4)), url({{$package->background_image}});
            min-height: 400px;
            height: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="page-vp-show">
        <x-header class="vp-background-image">
            <div class="page-vp-show__header">
                <h3 class="page-vp-show__header__heading">{{$package->name}}</h3>
            </div>
        </x-header>

        <div class="container page-vp-show__content">
            <div class="row">
                <div>
                    {!! $package->description !!}
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection
