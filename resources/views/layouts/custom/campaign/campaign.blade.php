@php

    $title = $title ?? '';
    $head_title = $head_title ?? '';
    $head_description = $head_description ?? '';
    $head_image = $head_image ?? '';
    $color = $color ?? '';
    $background = $background ?? '';
    $header = $header ?? '';
    $top = isset($top) ? collect($top) : collect();
    $sidebar_top = isset($sidebar_top) ? collect($sidebar_top) : collect();
    $content = isset($content) ? collect($content) : collect();
    $sidebar = isset($sidebar) ? collect($sidebar) : collect();
    $bottom = isset($bottom) ? collect($bottom) : collect();
    $footer = $footer ?? '';
    $narrow = $narrow ?? false;
    $content2 = $content2 ?? '';

@endphp

@extends('layouts.main')

@section('title', $title)
@section('head_title', $head_title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('color', $color)
@section('background')
    {!! $background !!}
@endsection

@section('header')

    <header class="">

        {!! $header !!}

    </header>

@endsection

@section('content')

    <div class="container">

        <section class="campaign">

        <div class="row padding-bottom-sm margin-top-md">

            <div class="col-8-tablet col-xs-12">

                    <div class="introduction">

                        <article>
                            <div class="backpack-icon">
                                <svg class="backpack">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-tickets"></use>
                                </svg>
                            </div>
                            <h2>
                                Aita kasvatada Trip.ee Facebooki fännide arvu ning sul on võimalus võita lennupiletid kahele X.
                            </h2>
                        </article>

                        <article>
                            <div class="backpack-icon">
                                <svg class="backpack">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-backpack"></use>
                                </svg>
                            </div>
                            <h2>
                                Lisaks loosime välja X mugavat Trip.ee sümboolikaga päevamatka seljakotti.
                            </h2>
                        </article>

                        <div class="how-to-win">
                            <div>
                                <h2>
                                    Kuidas võita?
                                </h2>

                                <p class="list-item">
                                    Märgi Trip.ee Facebookis meeldivaks.
                                </p>

                                <p class="list-item">
                                    Jaga ükskõik, mis meie postitust.
                                </p>

                                <p class="list-item">
                                    Tagi jagatud postituse kommentaarides, kellega sa tahaksid X minna.
                                </p>

                                <p class="list-item last">
                                    Peaauhinna võitja selgitame välja X fänni täitumisel ning iga X fänni
                                    täitumise puhul loosime välja ühe seljakoti.
                                </p>
                            </div>
                        </div>

                        <div class="fb">

                            <div class="fb-page"
                                 data-href="https://www.facebook.com/tripeeee/"
                                 data-width="500"
                                 data-hide-cover="false"
                                 data-adapt-container-width="true"
                                 data-show-facepile="true"></div>

                        </div>

                    </div> {{--end of introduction--}}

            </div>

            <div class="col-4-tablet small--hidden hidden-xs">
                <div class="introduction-trip-bag" style="background-image: url(/photos/trip-bag.jpg);"></div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-12-tablet">

                {!! $FbBackpackWidget !!}

            </div>
        </div>

        <div class="row">
            <div class="col-8-tablet col-xs-12">
                <div class="extra-info">
                    <div class="extra-info-content">

                        <div>
                            <h2>
                                Lisainfo ja tingimused
                            </h2>

                            <p>
                                X saab nautida aasta lõpuni
                            </p>

                            <p>
                                Reisi lõpp on kuni 31.12.2018
                            </p>

                            <p>
                                Lendude algus- ja lõpp-punkt on Tallinn
                            </p>

                            <p>
                                Lendudel tohib olla üks ümberistumine
                            </p>

                            <p>
                                Hinna sees on käsipagas
                            </p>

                            <p>
                                Kuupäevavaliku teeme võitjale teatavaks 5 päeva peale võidu selgitamist
                            </p>

                            <p>
                                Lennupiletitele märgitud nimesid muuta ei saa
                            </p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4-tablet col-xs-12">
                <div class="extra-info-sidebar">
                    <svg>
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="#constanta-campaign-map"></use>
                    </svg>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="view-more">
                <div class="view-more-flights">
                    <h2>
                        Vaata lisaks
                    </h2>

                    @foreach ($content as $content_item)

                        {!! $content_item !!}

                    @endforeach
                </div>

                {{--<div class="view-more-hotels">

                    {!! $HotelsCombined !!}

                </div>--}}
            </div>

        </div>

        </section>
    </div>



@endsection

@section('footer')

    <footer class="Two__footer">

        {!! $footer !!}

    </footer>

@endsection