@extends('layouts.medium')

@section('title')
    {{ trans($content->title) }}
@stop

@section('content.medium')

    <div class="utils-padding-bottom 
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

        {!! $content->body_filtered !!}

    </div>

@stop