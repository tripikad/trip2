@extends('layouts.one_column')

@section('title')
    {{ trans("content.$mode.title") }}
@stop

@section('content.one')

    {!! Form::model(isset($model) ? $model : null, [
        'url' => $url,
        'method' => isset($method) ? $method : 'post'
    ]) !!}

    <div class="c-form__input-wrap">
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
    </div>

    {!! Form::submit(trans("content.$mode.submit.title"), [
        'class' => 'c-button m-large m-block'
    ]) !!}

    {!! Form::close() !!}

@stop
