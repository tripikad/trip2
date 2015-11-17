@extends('layouts.one_column')

@section('title')
    {{ trans("content.$mode.title") }}
@stop

@section('content.one')

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

@stop
