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
            </div>
        </div>
    </div>

@stop
