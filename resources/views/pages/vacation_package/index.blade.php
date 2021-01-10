@extends('layouts.main2')

@section('content')

    <div class="page-vp-index">
        <x-header>
            <div class="page-vp-index__header-content">
                <h3 class="page-vp-index__header-content__heading">Puhkusepaketid</h3>
                <x-tabs :tabs="$categories"/>
            </div>
        </x-header>

        <div class="container page-vp-index__content">
            <div class="row">
                <div class="col-md-8 col-12">
                    @foreach ($packages->chunk(2) as $chunk)
                        <div class="row">
                            @foreach($chunk as $package)
                                <div class="col-md-6 page-vp-index__content__item">
                                    <x-vacation-package.griditem :package="$package"/>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
                <div class="col-md-3 col-12 mt-5 mt-md-0">
                    <x-ads id="{{config('promo.sidebar_small.id2')}}"/>
                    <x-ads id="{{config('promo.sidebar_large.id2')}}"/>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection
