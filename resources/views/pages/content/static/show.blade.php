@extends('layouts.one_column')

@section('title')
    {{ trans($content->title) }}
@stop

@section('content.one')

    <div class="
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

        {!! $content->body_filtered !!}

    </div>

@stop
