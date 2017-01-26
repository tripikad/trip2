@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

    <div class="r-forum m-add">
        <div class="r-forum__masthead">
            @include('component.masthead', [
                'modifiers' => 'm-alternative',
                'image' => \App\Image::getHeader()
            ])
        </div>

        <div class="r-forum__content-wrap">
            <div class="r-forum__wrap{{ (! in_array($type,['news', 'flight']) ? ' m-small' : '') }}">
                <div class="r-forum__content">
                    <div class="r-block m-small">
                        <div class="r-block__header">
                            <h1 class="c-flight-title m-large">{{ trans("content.$mode.title") }}</h1>
                        </div>

                        @if (trans("content.$type.add.rules") !== "content.$type.add.rules")
                            <div class="r-block__inner">
                                <div class="r-block__header">
                                    @include('component.title', [
                                        'modifiers' => 'm-red m-large',
                                        'title' => 'Hea teada'
                                    ])
                                </div>
                                <div class="r-block__body">
                                    <div class="c-body">
                                        <p>{!! nl2br(trans("content.$type.add.rules")) !!}</p>

                                        <!--@include('component.link', [
                                            'modifiers' => 'm-icon',
                                            'title' => 'Loe lähemalt',
                                            'route' => '#',
                                            'icon' => 'icon-arrow-right',
                                            'target' => '_blank',
                                        ])-->
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="r-block">
                        @include('component.image.form', [
                            'form' => [
                                    'url' => $url,
                                    'method' => isset($method) ? $method : 'post',
                                    'model' => isset($content) ? $content : null,
                                    'files' => in_array('file', array_column($fields, 'type'))
                                ],
                            'name' =>
                                !empty(array_keys($fields, ['type' => 'file'])) ? array_keys($fields, ['type' => 'file'])[0] : 'image',
                            'maxFileSize' => 5,
                            'maxFiles' => 1,
                            'uploadMultiple' => false,
                            'fields' => $fields
                        ])
                    </div>
                </div>
                @if (! in_array($type,['news', 'flight', 'buysell']) )
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
                                        'icon' => 'icon-arrow-right'
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@stop
