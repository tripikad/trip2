@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => ''
    ])

@stop

@section('content')

<div class="r-forum m-add">

    <div class="r-forum__masthead">

        @include('component.forum.masthead', [
            'modifiers' => 'm-small',
        ])

        <div class="r-forum__map">

            <div class="r-forum__map-inner">

                @include('component.map', [
                    'modifiers' => 'm-forum'
                ])
            </div>
        </div>
    </div>

    <div class="r-forum__content-wrap">

        <div class="r-forum__wrap m-small">

            <div class="r-forum__content">

                <h1 class="c-forum-title m-large">{{ trans('content.forum.create.title') }}</h1>

                <div class="r-block">

                    {!! Form::model(isset($model) ? $model : null, [
                        'url' => $url,
                        'method' => isset($method) ? $method : 'post'
                    ]) !!}

                    <div class="c-form__group">

                        {!! Form::label('name', trans('content.forum.edit.field.category.title'), [
                            'class' => 'c-form__label'
                        ]) !!}

                        <div class="c-columns m-2-cols m-border">

                        @foreach(config('menu.forum') as $index => $item)

                            <div class="c-columns__item">
                                <div class="c-form__group-radio js-radio-wrap">
                                    {{ Form::radio('type', $item['type'], null, [
                                        'class' => 'c-form__input m-radio js-radio',
                                        'id' => $item['type']
                                    ]) }}
                                    {!! Form::label($item['type'], trans($item['title']),[
                                        'class' => 'c-form__label m-radio js-radio'
                                    ]) !!}
                                </div>
                            </div>

                            @if (($index + 1) % 2 == 0)
                                <div class="c-columns m-2-cols m-border">
                                </div>
                            @endif
                        @endforeach

                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::label('section', 'Rubriik', [
                                'class' => 'c-form__label'
                            ]) !!}
                            <div class="c-form__group-select">
                                {!! Form::select('section', ['Reisivarustus', 'Lennupiletid', 'Muu'], null, [
                                    'class' => 'c-form__select',
                                    'id' => 'section',
                                    'placeholder' => 'Vali',
                                ]) !!}
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
                                'placeholder' => 'Teema pealkiri',
                            ]) !!}
                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::label('body', 'Sisu', [
                                'class' => 'c-form__label'
                            ]) !!}
                            {!! Form::textarea('body', null, [
                                'class' => 'c-form__input m-high',
                                'placeholder' => 'Postituse sisu. Enne kirjutamist tutvu kindlasti ka meie foorumi reeglitega…',
                            ]) !!}
                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::label('style', 'Reisistiil', [
                                'class' => 'c-form__label'
                            ]) !!}
                            <div class="c-form__group-select">
                                {!! Form::select('style', ['Seljakotireis', 'Lennureis', 'Muu'], null, [
                                    'class' => 'c-form__select',
                                    'id' => 'style',
                                    'placeholder' => 'Vali',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="c-form__input-wrap">
                        <div class="c-form__group">
                            {!! Form::label('destinations', 'Sihtkoht', [
                                'class' => 'c-form__label'
                            ]) !!}
                            {!! Form::select('destinations[]', $destinations, $destination, [
                                'class' => 'js-filter c-select',
                                'id' => 'destinations',
                                'multiple' => 'true',
                            ]) !!}
                        </div>
                    </div>

                    {!! Form::submit(trans("content.$mode.submit.title"), [
                        'class' => 'c-button m-large m-block'
                    ]) !!}

                    {!! Form::close() !!}

                </div>

            </div>

            <div class="r-forum__sidebar">

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
    </div>
    <div class="r-forum__footer-promo m-white">

        <div class="r-forum__footer-promo-wrap">

            @include('component.promo', ['promo' => 'footer'])

        </div>
    </div>
</div>

    <?php /* OLD FORM ELEMENTS

        {!! Form::model(isset($model) ? $model : null, [
            'url' => $url,
            'method' => isset($method) ? $method : 'post'
        ]) !!}

        <div class="c-form__input-wrap">
            <div class="c-form__group">
                {!! Form::text('title', null, [
                    'class' => 'c-form__input',
                    'placeholder' => trans("content.forum.edit.field.title.title"),
                ]) !!}
            </div>
        </div>

        <div class="c-form__input-wrap">
            <div class="c-form__group">
                {!! Form::textarea('body', null, [
                    'class' => 'c-form__input m-high',
                    'placeholder' => trans("content.forum.edit.field.body.title"),
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
        */
    ?>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop