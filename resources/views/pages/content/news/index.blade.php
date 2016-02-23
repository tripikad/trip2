@extends('layouts.main')


@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => trans('frontpage.index.search.title')
    ])

@stop

@section('content')

<div class="r-search">

    <div class="r-search__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-search m-alternative',
            'image' => \App\Image::getRandom()
        ])
    </div>

    <div class="r-search__tabs">

        <div class="r-search__tabs-wrap">

            <ul class="c-search-tabs">
                <li class="c-search-tabs__item"><a href="#" class="c-search-tabs__item-link m-active js-search-tab" data-tab="forum">Foorum <span>7</span></a></li>
                <li class="c-search-tabs__item"><a href="#" class="c-search-tabs__item-link js-search-tab" data-tab="blogs">Blogid <span>48</span></a></li>
                <li class="c-search-tabs__item"><a href="#" class="c-search-tabs__item-link js-search-tab" data-tab="news">Uudised <span>39</span></a></li>
                <li class="c-search-tabs__item"><a href="#" class="c-search-tabs__item-link js-search-tab" data-tab="destinations">Sihtkohad <span>12</span></a></li>
                <li class="c-search-tabs__item"><a href="#" class="c-search-tabs__item-link js-search-tab" data-tab="flights">Lennupakkumised <span>1</span></a></li>
                <li class="c-search-tabs__item"><a href="#" class="c-search-tabs__item-link js-search-tab" data-tab="users">Kasutajad <span>14</span></a></li>
            </ul>

        </div>
    </div>

    <div class="r-search__content">

        <div class="r-search__content-wrap">

            <div class="r-search__content-container">

                <div class="c-search-container m-active js-search-container" data-container="forum">

                    <ul class="c-search-forum">

                        <li class="c-search-forum__item">
                            <h3 class="c-search-forum__item-title">
                                <a href="#" class="c-search-forum__item-title-link"><span>Samui hotellid</span> <div class="c-badge m-inverted m-red">9</div></a>
                                <span class="c-search-forum__item-title-date">täna 18:30</span>
                            </h3>
                            <div class="c-search-forum__item-content">
                                <div class="c-search-forum__item-image" style="background-image: url({{\App\Image::getRandom()}});"></div>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-forum__item">
                            <h3 class="c-search-forum__item-title">
                                <a href="#" class="c-search-forum__item-title-link"><span>Soodsalt inglismaal rongi/metroo/bussiga? Kus hindu vaadata?</span> <div class="c-badge m-inverted m-red">7</div></a>
                                <span class="c-search-forum__item-title-date">eile 10:22</span>
                            </h3>
                            <div class="c-search-forum__item-content">
                                <div class="c-search-forum__item-image" style="background-image: url({{\App\Image::getRandom()}});"></div>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-forum__item">
                            <h3 class="c-search-forum__item-title">
                                <a href="#" class="c-search-forum__item-title-link"><span>Hanoist Sapasse – bussi, rongi, tsikli või autoga?</span> <div class="c-badge m-inverted m-red">2</div></a>
                                <span class="c-search-forum__item-title-date">12. jaanuar 2016</span>
                            </h3>
                            <div class="c-search-forum__item-content">
                                <div class="c-search-forum__item-image" style="background-image: url({{\App\Image::getRandom()}});"></div>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-forum__item">
                            <h3 class="c-search-forum__item-title">
                                <a href="#" class="c-search-forum__item-title-link"><span>Kuidas teha ideaalset Banh Mi’d?</span> <div class="c-badge m-inverted m-red">12</div></a>
                                <span class="c-search-forum__item-title-date">02. märts 2015</span>
                            </h3>
                            <div class="c-search-forum__item-content">
                                <div class="c-search-forum__item-image" style="background-image: url({{\App\Image::getRandom()}});"></div>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="c-search-container js-search-container" data-container="blogs">

                    <ul class="c-search-blogs">

                        <li class="c-search-blogs__item">
                            <a href="#" class="c-search-blogs__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-blogs__item-content">
                                <h3 class="c-search-blogs__item-title">
                                    <a href="#" class="c-search-blogs__item-title-link">Meie loodenaaber Rootsi ja tema käimata rajad</a>
                                    <span class="c-search-blogs__item-title-date">02. märts 2016</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-blogs__item">
                            <a href="#" class="c-search-blogs__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-blogs__item-content">
                                <h3 class="c-search-blogs__item-title">
                                    <a href="#" class="c-search-blogs__item-title-link">Cinque Terres hakatakse piirama külastajate arvu</a>
                                    <span class="c-search-blogs__item-title-date">28. veebruar 2015</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-blogs__item">
                            <a href="#" class="c-search-blogs__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-blogs__item-content">
                                <h3 class="c-search-blogs__item-title">
                                    <a href="#" class="c-search-blogs__item-title-link">Ryanair soovib Saksamaal kasvada 4 korda</a>
                                    <span class="c-search-blogs__item-title-date">09. juuli 2014</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-blogs__item">
                            <a href="#" class="c-search-blogs__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-blogs__item-content">
                                <h3 class="c-search-blogs__item-title">
                                    <a href="#" class="c-search-blogs__item-title-link">Nädalavahetuse filminurk: Namiibia</a>
                                    <span class="c-search-blogs__item-title-date">02. detsember 2012</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-blogs__item">
                            <a href="#" class="c-search-blogs__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-blogs__item-content">
                                <h3 class="c-search-blogs__item-title">
                                    <a href="#" class="c-search-blogs__item-title-link">Vene firma soovib konkureerida Airbusi ja Boeinguga</a>
                                    <span class="c-search-blogs__item-title-date">13. aprill 2012</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-blogs__item">
                            <a href="#" class="c-search-blogs__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-blogs__item-content">
                                <h3 class="c-search-blogs__item-title">
                                    <a href="#" class="c-search-blogs__item-title-link">Nädalavahetuse filminurk: mägiratastega Kaukasuses</a>
                                    <span class="c-search-blogs__item-title-date">19. mai 2011</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="c-search-container js-search-container" data-container="news">

                    <ul class="c-search-news">

                        <li class="c-search-news__item">
                            <a href="#" class="c-search-news__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-news__item-content">
                                <h3 class="c-search-news__item-title">
                                    <a href="#" class="c-search-news__item-title-link">Meie loodenaaber Rootsi ja tema käimata rajad</a>
                                    <span class="c-search-news__item-title-date">02. märts 2016</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-news__item">
                            <a href="#" class="c-search-news__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-news__item-content">
                                <h3 class="c-search-news__item-title">
                                    <a href="#" class="c-search-news__item-title-link">Cinque Terres hakatakse piirama külastajate arvu</a>
                                    <span class="c-search-news__item-title-date">28. veebruar 2015</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-news__item">
                            <a href="#" class="c-search-news__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-news__item-content">
                                <h3 class="c-search-news__item-title">
                                    <a href="#" class="c-search-news__item-title-link">Ryanair soovib Saksamaal kasvada 4 korda</a>
                                    <span class="c-search-news__item-title-date">09. juuli 2014</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-news__item">
                            <a href="#" class="c-search-news__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-news__item-content">
                                <h3 class="c-search-news__item-title">
                                    <a href="#" class="c-search-news__item-title-link">Nädalavahetuse filminurk: Namiibia</a>
                                    <span class="c-search-news__item-title-date">02. detsember 2012</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-news__item">
                            <a href="#" class="c-search-news__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-news__item-content">
                                <h3 class="c-search-news__item-title">
                                    <a href="#" class="c-search-news__item-title-link">Vene firma soovib konkureerida Airbusi ja Boeinguga</a>
                                    <span class="c-search-news__item-title-date">13. aprill 2012</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>

                        <li class="c-search-news__item">
                            <a href="#" class="c-search-news__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-news__item-content">
                                <h3 class="c-search-news__item-title">
                                    <a href="#" class="c-search-news__item-title-link">Nädalavahetuse filminurk: mägiratastega Kaukasuses</a>
                                    <span class="c-search-news__item-title-date">19. mai 2011</span>
                                </h3>
                                <p>… uudiseid vägivallast ja inimröövidest saabus <span>Vietnam</span> riigis pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="c-search-container js-search-container" data-container="destinations">

                    <ul class="c-search-destinations">

                        <li class="c-search-destinations__item">
                            <a href="#" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-destinations__item-content">
                                <h3 class="c-search-destinations__item-title">
                                    <a href="#" class="c-search-destinations__item-title-link">Vietnam</a>
                                </h3>
                                <ul class="c-search-destinations__item-info">
                                    <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-destinations__item">
                            <a href="#" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-destinations__item-content">
                                <h3 class="c-search-destinations__item-title">
                                    <a href="#" class="c-search-destinations__item-title-link">Hanoi</a>
                                </h3>
                                <ul class="c-search-destinations__item-info">
                                    <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Hanoi</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-destinations__item">
                            <a href="#" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-destinations__item-content">
                                <h3 class="c-search-destinations__item-title">
                                    <a href="#" class="c-search-destinations__item-title-link">Ho Chi Minh City</a>
                                </h3>
                                <ul class="c-search-destinations__item-info">
                                    <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Ho Chi Minh City</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-destinations__item">
                            <a href="#" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-destinations__item-content">
                                <h3 class="c-search-destinations__item-title">
                                    <a href="#" class="c-search-destinations__item-title-link">Nha Trang</a>
                                </h3>
                                <ul class="c-search-destinations__item-info">
                                    <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Nha Trang</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-destinations__item">
                            <a href="#" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-destinations__item-content">
                                <h3 class="c-search-destinations__item-title">
                                    <a href="#" class="c-search-destinations__item-title-link">Da Nang</a>
                                </h3>
                                <ul class="c-search-destinations__item-info">
                                    <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Da Nang</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-destinations__item">
                            <a href="#" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-destinations__item-content">
                                <h3 class="c-search-destinations__item-title">
                                    <a href="#" class="c-search-destinations__item-title-link">Hoi An</a>
                                </h3>
                                <ul class="c-search-destinations__item-info">
                                    <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                                    <li><a href="#" class="c-search-destinations__item-info-link">Hoi An</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="c-search-container js-search-container" data-container="flights">

                    <ul class="c-search-flights">

                        <li class="c-search-flights__item">
                            <a href="#" class="c-search-flights__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-flights__item-content">
                                <h3 class="c-search-flights__item-title">
                                    <a href="#" class="c-search-flights__item-title-link">Lufthansa lennupiletid Helsingist Hanoisse al 365 €</a>
                                    <span class="c-search-flights__item-title-date">02. märts 2016</span>
                                </h3>
                                <ul class="c-search-flights__item-info">
                                    <li>Hanoi, Vietnam</li>
                                    <li>Jaanuar – Veebruar 2017</li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-flights__item">
                            <a href="#" class="c-search-flights__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-flights__item-content">
                                <h3 class="c-search-flights__item-title">
                                    <a href="#" class="c-search-flights__item-title-link">Võimalikud veahinnad rootsist Ho Chi Minh City’sse al 400 €</a>
                                    <span class="c-search-flights__item-title-date">28. veebruar 2015</span>
                                </h3>
                                <ul class="c-search-flights__item-info">
                                    <li>Hanoi, Vietnam</li>
                                    <li>Jaanuar – Veebruar 2017</li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-flights__item">
                            <a href="#" class="c-search-flights__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-flights__item-content">
                                <h3 class="c-search-flights__item-title">
                                    <a href="#" class="c-search-flights__item-title-link">Helsinkist Aasiasse puhkama al 472 €</a>
                                    <span class="c-search-flights__item-title-date">09. juuli 2014</span>
                                </h3>
                                <ul class="c-search-flights__item-info">
                                    <li>Hanoi, Vietnam</li>
                                    <li>Jaanuar – Veebruar 2017</li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-flights__item">
                            <a href="#" class="c-search-flights__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-flights__item-content">
                                <h3 class="c-search-flights__item-title">
                                    <a href="#" class="c-search-flights__item-title-link">Edasi-tagasi otselennud Stockholmist või Oslost Da Nangi al 242 €</a>
                                    <span class="c-search-flights__item-title-date">02. detsember 2012</span>
                                </h3>
                                <ul class="c-search-flights__item-info">
                                    <li>Hanoi, Vietnam</li>
                                    <li>Jaanuar – Veebruar 2017</li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-flights__item">
                            <a href="#" class="c-search-flights__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-flights__item-content">
                                <h3 class="c-search-flights__item-title">
                                    <a href="#" class="c-search-flights__item-title-link">Lufthansa lennupiletid Helsingist Hanoisse al 365 €</a>
                                    <span class="c-search-flights__item-title-date">13. aprill 2012</span>
                                </h3>
                                <ul class="c-search-flights__item-info">
                                    <li>Hanoi, Vietnam</li>
                                    <li>Jaanuar – Veebruar 2017</li>
                                </ul>
                            </div>
                        </li>

                        <li class="c-search-flights__item">
                            <a href="#" class="c-search-flights__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
                            <div class="c-search-flights__item-content">
                                <h3 class="c-search-flights__item-title">
                                    <a href="#" class="c-search-flights__item-title-link">Võimalikud veahinnad rootsist Ho Chi Minh City’sse al 400 €</a>
                                    <span class="c-search-flights__item-title-date">19. mai 2011</span>
                                </h3>
                                <ul class="c-search-flights__item-info">
                                    <li>Hanoi, Vietnam</li>
                                    <li>Jaanuar – Veebruar 2017</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="c-search-container js-search-container" data-container="users">

                    <ul class="c-search-users">

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'status' => [
                                        'modifiers' => 'm-yellow',
                                        'position' => '2',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Helena Parma</a>
                            </h3>
                        </li>

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'route' => '#',
                                    'letter' => [
                                        'modifiers' => 'm-yellow m-small',
                                        'text' => 'K'
                                    ],
                                    'status' => [
                                        'modifiers' => 'm-yellow',
                                        'position' => '1',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Korval Kaup</a>
                            </h3>
                        </li>

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',

                                    'status' => [
                                        'modifiers' => 'm-red',
                                        'position' => '1',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Maalika Meriforell</a>
                            </h3>
                        </li>

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',

                                    'status' => [
                                        'modifiers' => 'm-purple',
                                        'position' => '3',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Trainer Roomassaare Juunior</a>
                            </h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="r-search__footer-promo">

        <div class="r-search__footer-promo-wrap">

            @include('component.promo', [
                'modifiers' => 'm-footer',
                'route' => '',
                'image' => \App\Image::getRandom()
            ])
        </div>
    </div>
</div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop