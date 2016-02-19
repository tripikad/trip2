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

                    @include('component.title', [
                        'modifiers' => 'm-largest m-blue',
                        'title' => 'Lennupakkumiste lisamine'
                    ])
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

                {!! Form::model(isset($model) ? $model : null, [
                    'url' => $url,
                    'method' => isset($method) ? $method : 'post'
                ]) !!}

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('destinations', 'Sihtkoht', [
                            'class' => 'c-form__label'
                        ]) !!}
                        {!! Form::select('destinations[]', $destinations, $destination, [
                            'class' => 'js-filter c-select',
                            'id' => 'destinations',
                            'multiple' => 'true',
                            'placeholder' => 'Vali…'
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('company', 'Lennufirma', [
                            'class' => 'c-form__label'
                        ]) !!}
                        {!! Form::select('company', ['Alaskan airlines', 'Lufthansa'], null, [
                            'class' => 'js-filter ',
                            'id' => 'company',
                            'placeholder' => 'Vali…'
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('tags', 'Tag\'id', [
                            'class' => 'c-form__label'
                        ]) !!}
                        {!! Form::select('tags', ['Eksootiline', 'Seljakotireis'], null, [
                            'class' => 'js-filter ',
                            'id' => 'tags',
                            'placeholder' => 'Vali…'
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__group">

                    {!! Form::label('date_start', 'Reisiperiood', [
                        'class' => 'c-form__label'
                    ]) !!}

                    <div class="c-columns m-2-cols m-space">

                        <div class="c-columns__item">
                            <div class="c-form__input-wrap">
                                <span class="c-form__input-icon">

                                    @include('component.svg.sprite', ['name' => 'icon-calendar'])
                                </span>
                                {!! Form::text('date_start', null, [
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
                                {!! Form::text('date_end', null, [
                                    'class' => 'c-form__input m-icon',
                                    'placeholder' => '17.03.2016',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-form__group">

                    {!! Form::label('flight_start', 'Lennumarsruut', [
                        'class' => 'c-form__label'
                    ]) !!}

                    <div class="c-columns m-2-cols m-space">

                        <div class="c-columns__item">
                            <div class="c-form__input-wrap">
                                {!! Form::text('flight_start', null, [
                                    'class' => 'c-form__input',
                                    'placeholder' => 'Alguskoht',
                                ]) !!}
                            </div>
                        </div>

                        <div class="c-columns__item">
                            <div class="c-form__input-wrap">
                                {!! Form::text('flight_end', null, [
                                    'class' => 'c-form__input',
                                    'placeholder' => 'Sihtkoht',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('title', 'Pealkiri', [
                            'class' => 'c-form__label'
                        ]) !!}
                        {!! Form::text('title', null, [
                            'class' => 'c-form__input',
                            'placeholder' => 'Pakkumise pealkiri',
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('body', 'Sisu', [
                            'class' => 'c-form__label'
                        ]) !!}
                        {!! Form::textarea('body', null, [
                            'class' => 'c-form__input m-high js-ckeditor',
                            'placeholder' => 'Pakkumise sisu (lubatud html koodi sisestamine)…',
                            'rows' => 16
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('screenshot', 'Ekraanitõmmise üleslaadimine', [
                            'class' => 'c-form__label'
                        ]) !!}
                        <div id="screenshot" class="dropzone"></div>
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::label('flight_image', 'Pakkumise foto üleslaadimine', [
                            'class' => 'c-form__label'
                        ]) !!}

                        <div id="flight_image" class="dropzone"></div>
                    </div>
                </div>

                <div class="c-form__note">Enne pakkumise sisestamist kontrolli palun uuesti kõik sisestatud andmed</div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        <a href="#" class="c-button m-tertiary m-large m-block">Vaata eelvaadet</a>
                    </div>
                </div>

                {{-- <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::text('title', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans("content.flight.edit.field.title.title"),
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::text('image_id', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans("content.flight.edit.field.image_id.title"),
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::textarea('body', null, [
                            'class' => 'c-form__input m-high js-ckeditor',
                            'placeholder' => trans("content.flight.edit.field.body.title"),
                            'rows' => 16
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::select('destinations[]', $destinations, $destination, [
                            'class' => 'js-filter',
                            'id' => 'destinations',
                            'multiple' => 'true',
                            'placeholder' => trans("content.flight.edit.field.destinations.title"),
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        <div class="c-form__label">
                            {{ trans("content.flight.edit.field.start_at.title") }}
                        </div>

                        <div class="c-columns m-6-cols m-space">
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 1,
                                    'to' => 31,
                                    'selected' => \Carbon\Carbon::now()->day,
                                    'key' => 'start_at_day'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'month' => true,
                                    'selected' => \Carbon\Carbon::now()->month,
                                    'key' => 'start_at_month'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => \Carbon\Carbon::now()->year,
                                    'to' => \Carbon\Carbon::parse('+5 years')->year,
                                    'selected' => \Carbon\Carbon::now()->year,
                                    'key' => 'start_at_year'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 0,
                                    'to' => 23,
                                    'selected' => \Carbon\Carbon::now()->hour,
                                    'key' => 'start_at_hour'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 0,
                                    'to' => 59,
                                    'selected' => \Carbon\Carbon::now()->minute,
                                    'key' => 'start_at_minute'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 0,
                                    'to' => 59,
                                    'selected' => '00',
                                    'key' => 'start_at_second'
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        <div class="c-form__label">
                            {{ trans("content.flight.edit.field.end_at.title") }}
                        </div>

                        <div class="c-columns m-6-cols m-space">
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 1,
                                    'to' => 31,
                                    'selected' => \Carbon\Carbon::now()->day,
                                    'key' => 'end_at_day'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'month' => true,
                                    'selected' => \Carbon\Carbon::now()->month,
                                    'key' => 'end_at_month'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => \Carbon\Carbon::now()->year,
                                    'to' => \Carbon\Carbon::parse('+5 years')->year,
                                    'selected' => \Carbon\Carbon::now()->year,
                                    'key' => 'end_at_year'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 0,
                                    'to' => 23,
                                    'selected' => \Carbon\Carbon::now()->hour,
                                    'key' => 'end_at_hour'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 0,
                                    'to' => 59,
                                    'selected' => \Carbon\Carbon::now()->minute,
                                    'key' => 'end_at_minute'
                                ])
                            </div>
                            <div class="c-columns__item">
                                @include('component.date.select', [
                                    'from' => 0,
                                    'to' => 59,
                                    'selected' => '00',
                                    'key' => 'end_at_second'
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::text('price', null, [
                            'class' => 'c-form__input m-narrow',
                            'placeholder' => trans("content.flight.edit.field.price.title"),
                        ]) !!}
                        <span class="c-form__text">
                            {{ config('site.currency.symbol') }}
                        </span>
                    </div>
                </div>

                <div class="c-form__input-wrap">
                    <div class="c-form__group">
                        {!! Form::url('url', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans("content.flight.edit.field.url.title"),
                        ]) !!}
                    </div>
                </div> --}}

                {!! Form::submit(trans("content.$mode.submit.title"), [
                    'class' => 'c-button m-large m-block'
                ]) !!}

                {!! Form::close() !!}
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