@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-travelmates">

    <div class="r-travelmates__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getRandom(),
            'subtitle' => ''
        ])

    </div>

    <div class="r-travelmates__wrap m-small">

        <div class="r-travelmates__content">

            <div class="r-block">

                <div class="r-block__header">

                    <h1 class="c-travelmate-title m-large">Lisa uus kuulutus</h1>

                </div>

                {!! Form::model(isset($model) ? $model : null, [
                    'url' => $url,
                    'method' => isset($method) ? $method : 'post'
                ]) !!}

                <div class="c-form__group">
                    {!! Form::label('destinations', 'Sihtkoht', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::select('destinations[]', $destinations, $destination, [
                        'class' => 'js-filter',
                        'id' => 'destinations',
                        'multiple' => 'true',
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('topics', 'Reisistiil', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <div class="c-form__group-select">
                        {!! Form::select('topics[]', $topics, $topic, [
                            'class' => 'c-form__select',
                            'id' => 'topics',
                            'placeholder' => 'Vali stiil',
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__group">
                    <div class="c-form__label">
                        {{ trans("content.travelmate.edit.field.start_at.title") }}
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

                <div class="c-form__group">
                    {!! Form::label('planned_date', 'Planeeritud aeg', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <div class="c-form__group-select">
                        {!! Form::select('planned_date', ['Talv 2016', 'Suvi 2017', 'Kevad 2017'], null, [
                            'class' => 'c-form__select',
                            'id' => 'topics',
                            'placeholder' => 'Vali aeg',
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__group">
                    {!! Form::label('body', 'Sobiva kaaslase kirjeldus', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::textarea('body', null, [
                        'class' => 'c-form__input m-high js-ckeditor',
                        'id' => 'body',
                        'placeholder' => 'Kirjelda sinule sobivat reisikaaslast. Kui oled nõus reisima igaühega, siis ütle ka seda …',
                    ]) !!}
                </div>

                <div class="c-form__group">

                    {!! Form::label('name', 'Sugu', [
                        'class' => 'c-form__label'
                    ]) !!}

                    <div class="c-columns m-3-cols">

                        <div class="c-columns__item m-middle">
                            {{ Form::radio('sex', 1, null, [
                                'class' => 'c-form__input m-radio',
                                'id' => 'sex-1'
                            ]) }}

                            {!! Form::label('sex-1', 'Mees',[
                                'class' => 'c-form__label m-radio'
                            ]) !!}
                        </div>

                        <div class="c-columns__item m-middle">

                            {{ Form::radio('sex', 1, null, [
                                'class' => 'c-form__input m-radio',
                                'id' => 'sex-2'
                            ]) }}

                            {!! Form::label('sex-2', 'Naine',[
                                'class' => 'c-form__label m-radio'
                            ]) !!}
                        </div>

                        <div class="c-columns__item m-middle">

                            {{ Form::radio('sex', 1, null, [
                                'class' => 'c-form__input m-radio',
                                'id' => 'sex-3'
                            ]) }}

                            {!! Form::label('sex-3', 'Kõik sobib',[
                                'class' => 'c-form__label m-radio'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="c-form__group">
                    {!! Form::label('title', 'Pealkiri', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::text('title', null, [
                        'class' => 'c-form__input',
                        'placeholder' => 'nt. "Seiklusreis Alaskale", "Veebruaris Aasiasse" jms',
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('additional_info', 'Lisainfo', [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::textarea('additional_info', null, [
                        'class' => 'c-form__input m-high js-ckeditor',
                        'id' => 'additional_info',
                        'placeholder' => 'Sinu nägemus reisist (mida kindlalt soovid näha, mis on umbkaudne eelarve jms)…',
                    ]) !!}
                </div>

                {!! Form::submit(trans("content.$mode.submit.title"), [
                    'class' => 'c-button m-large m-block'
                ]) !!}

                {!! Form::close() !!}

                <?php /*

                    OLD FORM ELEMENTS

                    {!! Form::model(isset($model) ? $model : null, [
                        'url' => $url,
                        'method' => isset($method) ? $method : 'post'
                    ]) !!}

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::text('title', null, [
                                'class' => 'c-form__input',
                                'placeholder' => trans("content.travelmate.edit.field.title.title"),
                            ]) !!}
                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::textarea('body', null, [
                                'class' => 'c-form__input m-high',
                                'placeholder' => trans("content.travelmate.edit.field.body.title"),
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
                                'placeholder' => trans("content.travelmate.edit.field.destinations.title"),
                            ]) !!}
                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::select('topics[]', $topics, $topic, [
                                'class' => 'js-filter',
                                'id' => 'topics',
                                'multiple' => 'true',
                                'placeholder' => trans("content.travelmate.edit.field.topics.title"),
                            ]) !!}
                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            <div class="c-form__label">
                                {{ trans("content.travelmate.edit.field.start_at.title") }}
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
                            {!! Form::text('duration', null, [
                                'class' => 'c-form__input',
                                'placeholder' => trans("content.travelmate.edit.field.duration.title"),
                            ]) !!}
                        </div>
                    </div>

                    {!! Form::submit(trans("content.$mode.submit.title"), [
                        'class' => 'c-button m-large m-block'
                    ]) !!}

                    {!! Form::close() !!}

                */ ?>

            </div>

        </div>

        <div class="r-travelmates__sidebar">

            <div class="r-block m-small">

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
                            <p>Ma ei ropenda, halvusta teisi ega kasutata Trip.ee'd rassismi, usupropaganda või muul moel kitsarinnalisuse levitamiseks.</p>
                            <p>Ma ei avalda reklaamsisuga teateid, selleks kasutan Trip.ee <a href="#">ärikasutaja kontot või reklaamivõimalust</a>.</p>
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
        </div>
    </div>

    <div class="r-travelmates__footer-promo">
        <div class="r-travelmates__footer-promo-wrap">

            @include('component.promo', ['promo' => 'footer'])

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
