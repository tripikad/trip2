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

@stop
