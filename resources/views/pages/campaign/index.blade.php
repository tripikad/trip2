@extends('layouts.main')

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('head_description', trans('site.description.main'))

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => trans('frontpage.index.search.title')
    ])

@stop

@section('content')

    <section class="backpack-promotion">
        <div class="r-flights__masthead">
            <div class="c-masthead m-alternative" style="background-image: url(/photos/trip-camp-bgimg.jpg);">
                <div class="c-masthead__body">
                    <div class="c-masthead__logo"><a href="/" class="c-masthead__logo-link">
                            <div class="c-logo "><img src="/V1dist/tripee_logo.svg" alt=""></div>
                        </a></div>
                    <h1 class="c-masthead__title"> Tripi sõbra või kallimaga Maltale </h1></div>
                <div class="c-masthead__bottom"></div>
            </div>
        </div>

        <div class="introduction r-flights__content-wrap">
            <div class="r-flights__content">
                <article class="c-row m-icon">
                    <div class="c-row__icon">
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/V1dist/main.svg#icon-tickets">

                            </use>
                        </svg>
                    </div>
                    <h2 class="c-row__title">
                        Aita kasvatada Trip.ee Facebooki fännide arvu ning sul on võimalus võita lennupiletid kahele
                        Maltale.
                    </h2>
                </article>
                <article class="c-row m-icon">
                    <div class="c-row__icon">
                        <svg class="backpack">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/V1dist/main.svg#trip-bag-blue">

                            </use>
                        </svg>
                    </div>
                    <h2 class="c-row__title">
                        Lisaks loosime välja 9 mugavat Trip.ee sümboolikaga päevamatka seljakotti.
                    </h2>
                </article>

                <div class="r-block m-small how-to-win">
                    <div class="c-about ">
                        <div class="c-about__content">
                            <h2 class="c-about__title">
                                Kuidas võita?
                            </h2>

                            <p class="c-about__text list-item">
                                Märgi Trip.ee Facebookis meeldivaks.
                            </p>

                            <p class="c-about__text list-item">
                                Jaga ükskõik, mis meie postitust.
                            </p>

                            <p class="c-about__text list-item last">
                                Tagi jagatud postituse kommentaarides, kellega sa tahaksid Maltale minna.
                            </p>

                            <p class="c-about__text">
                                Peaauhinna võitja selgitame välja 40 000 fänni täitumisel ning iga 1000 fänni
                                täitumise puhul loosime välja ühe seljakoti.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="r-block m-small fb">
                    <div class="fb-page" data-href="https://www.facebook.com/tripeeee/" data-small-header="true"
                         data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true">
                        <blockquote cite="https://www.facebook.com/tripeeee/" class="fb-xfbml-parse-ignore"><a
                                    href="https://www.facebook.com/tripeeee/">Trip.ee</a></blockquote>
                    </div>
                </div>

            </div>

            <div class="introduction-sidebar" style="background-image: url(/photos/trip-bag.jpg);"></div>

        </div>

        <div class="r-full-width promotion-slider">
            <div class="r-block-full-width">
                <div class="promotion-counter-container">
                    <div class="promotion-line-background">
                        <div class="promotion-line-striped"></div>

                        <div class="circle-container">
                            <div class="circle">
                                <p>31000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>32000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>33000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>34000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>35000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>36000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>37000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>38000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle">
                                <p>39000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-bag"></use>
                                </svg>
                            </div>
                            <div class="circle last">
                                <p>40000</p>
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/V1dist/main.svg#trip-tickets-green"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="extra-info r-flights__content-wrap">
            <div class="r-flights__content">

                <div class="r-block m-small">
                    <div class="c-about ">
                        <div class="c-about__content">
                            <h2 class="c-about__title">
                                Lisainfo ja tingimused
                            </h2>

                            <p class="c-about__text">
                                Maltat saab nautida minimaalselt 6 päeva ja maksimaalselt 15 päeva, pärast mida
                                peaks teil juba karm koduigatsus tekkima, sest tõenäoliselt on siis juba Eestis
                                suvised ilmad.
                            </p>

                            <p class="c-about__text">
                                Reisi ajavahemik on 20.05.2017 - 31.07.2017
                            </p>

                            <p class="c-about__text">
                                Lendude algus- ja lõpp-punkt on Tallinn
                            </p>

                            <p class="c-about__text">
                                Lendudel tohib olla üks ümberistumine
                            </p>

                            <p class="c-about__text">
                                Hinna sees on käsipagas
                            </p>

                            <p class="c-about__text">
                                Kuupäevavaliku teeme võitjale teatavaks 5 päeva peale võidu selgitamist
                            </p>

                            <p class="c-about__text">
                                Lennupiletitele märgitud nimesid muuta ei saa
                            </p>

                            <h2 class="c-about__title">
                                Vaata lisaks
                            </h2>

                            <ul class="c-forum-list-nav">
                                <li class="c-forum-list-nav__item"><a href="/odavad-lennupiletid"
                                                                      class="c-forum-list-nav__item-link">Lennupiletite sooduspakkumised
                                        <span class="c-forum-list-nav__item-icon"> <svg>
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xlink:href="/V1dist/main.svg#icon-arrow-right"></use>
										</svg> </span> </a></li>
                                <li class="c-forum-list-nav__item "><a href="/foorum/uldfoorum"
                                                                       class="c-forum-list-nav__item-link">Tripikate foorum
                                        <span class="c-forum-list-nav__item-icon"> <svg>
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xlink:href="/V1dist/main.svg#icon-arrow-right"></use>
										</svg> </span> </a></li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="extra-info-sidebar">
                <svg>
                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                         xlink:href="/V1dist/main.svg#trip-campaign-map"></use>
                </svg>
            </div>

        </div>

    </section>

@stop

@section('footer')
    @include('component.footer', [
    'modifiers' => 'm-alternative',
    'image' => \App\Image::getFooter()
    ])

@stop