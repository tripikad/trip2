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
            'image' => \App\Image::getHeader(),
            'subtitle' => ''
        ])
    </div>
    <div class="r-travelmates__wrap m-small">
        <div class="r-travelmates__content">
            <div class="r-block">
                <div class="r-block__header">
                    <h1 class="c-travelmate-title m-large">{{ trans("content.forum.$mode.title") }}</h1>
                </div>

                {!! Form::model(isset($content) ? $content : null, [
                           'url' => $url,
                           'method' => isset($method) ? $method : 'post'
                       ]) !!}

                @include('component.image.form', [
                    'form' => [
                        'files' => null
                    ],
                    'fields' => $fields
                ])

                {!! Form::close() !!}
            </div>
        </div>
        <div class="r-travelmates__sidebar">
            <div class="r-block m-small">
                <div class="r-block__inner">
                    <div class="r-block__header">
                        @include('component.title', [
                            'modifiers' => 'm-red m-large',
                            'title' => trans('content.edit.notes.heading')
                        ])
                    </div>

                    <div class="r-block__body">
                        <div class="c-body">
                            {!! trans('content.edit.notes.body', [
                                'route' => route('static.show', [22125])
                            ]) !!}

                            @include('component.link', [
                                'modifiers' => 'm-icon',
                                'title' => trans('content.action.continue.reading'),
                                'route' => route('static.show', [25151]),
                                'icon' => 'icon-arrow-right',
                                'target' => '_blank',
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
        'image' => \App\Image::getFooter()
    ])
@stop
