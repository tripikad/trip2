@extends('layouts.one_column')

@section('title')
    {{ trans($content->title) }}
@stop

@section('content.one')
        
    {!! $content->body_filtered !!}

@stop
