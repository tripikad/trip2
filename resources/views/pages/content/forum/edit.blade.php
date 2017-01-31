@extends('layouts.main')

    @section('title', trans("content.$type.index.title"))

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
                    <h1 class="c-forum-title m-large">{{ trans("content.forum.$mode.title") }}</h1>
                    <div class="r-block">
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
                <div class="r-forum__sidebar">
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
        </div>
        <div class="r-forum__footer-promo m-white">
            <div class="r-forum__footer-promo-wrap">
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