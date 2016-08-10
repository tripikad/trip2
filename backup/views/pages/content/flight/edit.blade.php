{{-- To-do V2 ??? --}}

@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-flights m-create">

    <div class="r-flights__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getRandom()
        ])
    </div>

    <div class="r-flights__content-wrap">

        <div class="r-flights__content">

            <div class="r-block m-small">

                <div class="r-block__header">

                    <h1 class="c-flight-title m-large">Lennupakkumiste lisamine</h1>
                </div>

                <div class="r-block__inner">

                    <div class="r-block__header">

                        @include('component.title', [
                            'modifiers' => 'm-red m-large',
                            'title' => 'Hea teada'
                        ])
                    </div>

                    <div class="r-block__body">

                        <div class="c-body">

                            <p>Austan eesti keele reegleid, jälgin et minu kirjutised oleks loetavad, ma ei kasuta slängi, suurtähti ja korduvaid kirjavahemärke ning kasutan suuri algustähti lause alguses ja kohanimedes.</p>
                            <p>Tean ja nõustun, et kasutustingimuste rikkumisel võidakse minu kasutuskonto ilma hoiatamata sulgeda ja/või minu ligipääs Trip.ee'le blokeerida.</p>

                            @include('component.link', [
                                'modifiers' => 'm-icon',
                                'title' => 'Loe lähemalt',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="r-block">

                <div class="c-form__group">
                    {!! Form::label('add-flight-destinations', 'Sihtkoht', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::select('add-flight-destinations', ['Aafrika', 'Ameerika', 'Euroopa'], null, [
                        'class' => 'js-filter ',
                        'id' => 'add-flight-destinations',
                        'multiple' => 'true',
                        'placeholder' => 'Vali…'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('add-flight-company', 'Lennufirma', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::select('add-flight-company', ['Alaskan airlines', 'Lufthansa'], null, [
                        'class' => 'js-filter ',
                        'id' => 'add-flight-company',
                        'placeholder' => 'Vali…'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('add-flight-tags', 'Tag\'id', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::select('add-flight-tags', ['Eksootiline', 'Seljakotireis'], null, [
                        'class' => 'js-filter ',
                        'id' => 'add-flight-tags',
                        'placeholder' => 'Vali…'
                    ]) !!}
                </div>

                <div class="c-form__group">

                    {!! Form::label('add-flight-date_start', 'Reisiperiood', [
                        'class' => 'c-form__label'
                    ]) !!}

                    <div class="c-columns m-2-cols m-space">

                        <div class="c-columns__item m-mobile-margin">
                            <div class="c-form__input-wrap">
                                <span class="c-form__input-icon">

                                    @include('component.svg.sprite', ['name' => 'icon-calendar'])
                                </span>
                                {!! Form::text('add-flight-date_start', null, [
                                    'class' => 'c-form__input  m-icon',
                                    'placeholder' => '25.02.2016',
                                ]) !!}
                            </div>
                        </div>

                        <div class="c-columns__item">
                            <div class="c-form__input-wrap">
                                <span class="c-form__input-icon">

                                    @include('component.svg.sprite', ['name' => 'icon-calendar'])
                                </span>
                                {!! Form::text('add-flight-date_end', null, [
                                    'class' => 'c-form__input m-icon',
                                    'placeholder' => '17.03.2016',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-form__group m-small-margin">

                    {!! Form::label('add-flight-flight_start', 'Lennumarsruut', [
                        'class' => 'c-form__label'
                    ]) !!}

                    <div class="c-flight-route js-flight-route">

                        <div class="c-flight-route__row js-flight-route-row">

                            <div class="c-flight-route__column m-first">
                                {!! Form::text('add-flight-flight_start', null, [
                                    'class' => 'c-form__input',
                                    'placeholder' => 'Alguskoht',
                                ]) !!}
                            </div>

                            <div class="c-flight-route__column m-last">
                                {!! Form::text('add-flight-flight_end', null, [
                                    'class' => 'c-form__input',
                                    'placeholder' => 'Sihtkoht',
                                ]) !!}
                            </div>

                            <a href="#" class="c-flight-route__remove js-flight-route-remove">
                                @include('component.svg.sprite', [
                                    'name' => 'icon-circle-remove'
                                ])
                            </a>
                        </div>
                    </div>

                    <div class="js-flight-route-container"></div>
                </div>

                <div class="c-form__group">
                    @include('component.link', [
                        'modifiers' => 'm-icon-prepend js-add-flight-route',
                        'title' => 'Lisa rida',
                        'route' => '',
                        'icon' => 'icon-circle-add'
                    ])
                </div>

                <div class="c-form__group">
                    {!! Form::label('add-flight-title', 'Pealkiri', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::text('add-flight-title', null, [
                        'class' => 'c-form__input',
                        'placeholder' => 'Pakkumise pealkiri',
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('add-flight-body', 'Sisu', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::textarea('add-flight-body', null, [
                        'class' => 'c-form__input m-high js-ckeditor',
                        'placeholder' => 'Pakkumise sisu (lubatud html koodi sisestamine)…',
                        'rows' => 16,
                        'id' => 'add-flight-body'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('add-flight-screenshot', 'Ekraanitõmmise üleslaadimine', [
                        'class' => 'c-form__label'
                    ]) !!}

                    @include('component.image.form', [
                       'form' => [
                           'url' => '/content/flight/edit',
                           'files' => true
                       ],
                       'name' => 'add-flight-screenshot',
                       'maxFileSize' => 5,
                       'uploadMultiple' => true,
                       'fields' => null
                   ])

                </div>

                <div class="c-form__group m-large-margin">
                    {!! Form::label('add-flight_image', 'Pakkumise foto üleslaadimine', [
                        'class' => 'c-form__label'
                    ]) !!}

                    @include('component.image.form', [
                       'form' => [
                           'url' => '/content/flight/edit',
                           'files' => true
                       ],
                       'name' => 'add-flight_image',
                       'maxFileSize' => 5,
                       'uploadMultiple' => true,
                       'fields' => null
                   ])

                </div>

                <div class="c-form__group m-no-margin">

                    <h2 class="c-flight-title">Näidiskuupäevad</h2>
                </div>

                <div class="c-flight-dates js-flight-dates">

                    <div class="c-flight-dates__row js-flight-dates-row">

                        <div class="c-flight-dates__column m-first">
                            {!! Form::text('add-flight-title', null, [
                                'class' => 'c-form__input',
                                'placeholder' => 'Kuu ja aasta',
                            ]) !!}
                        </div>

                        <div class="c-flight-dates__column m-last">

                            {!! Form::textarea('add-flight-body2', null, [
                                'class' => 'c-form__input m-high js-ckeditor',
                                'placeholder' => 'Pakkumise sisu (lubatud html koodi sisestamine)…',
                                'rows' => 16,
                                'id' => 'add-flight-body2'
                            ]) !!}
                        </div>

                        <a href="#" class="c-flight-dates__remove js-flight-dates-remove">
                            @include('component.svg.sprite', [
                                'name' => 'icon-circle-remove'
                            ])
                        </a>
                    </div>
                </div>

                <div class="js-flight-dates-container"></div>

                <div class="c-form__group m-large-margin">
                    @include('component.link', [
                        'modifiers' => 'm-icon-prepend js-add-flight-dates',
                        'title' => 'Lisa rida',
                        'route' => '',
                        'icon' => 'icon-circle-add'
                    ])
                </div>

                <div class="c-form__note">Enne pakkumise sisestamist kontrolli palun uuesti kõik sisestatud andmed</div>

                <div class="c-form__group m-small-margin">
                    <a href="#" class="c-button m-tertiary m-large m-block">Vaata eelvaadet</a>
                </div>

                {!! Form::submit('Lisa sooduspakkumine', [
                    'class' => 'c-button m-large m-block'
                ]) !!}

            </div>
        </div>
    </div>

    <div class="r-flights__footer-promo m-white">

        <div class="r-flights__footer-promo-wrap">

            @include('component.promo', [
                'modifiers' => 'm-footer',
                'route' => '#',
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