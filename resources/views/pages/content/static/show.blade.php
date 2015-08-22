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

        {!! nl2br($content->body) !!}

    </div>

@stop