@php

$title = $title ?? '';
$head_title = $head_title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$head_robots = $head_robots ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$top = isset($top) ? collect($top) : collect();
$content_top = $content_top ?? '';
$content = isset($content) ? collect($content) : collect();
$bottom = isset($bottom) ? collect($bottom) : collect();
$footer = $footer ?? '';

@endphp

@extends('layouts.main')

@section('title', $title)
@section('head_title', $head_title)
@section('head_description', $head_description)
@section('head_image', $head_image)
@section('head_robots', $head_robots)

@section('color', $color)
@section('background')
{!! $background !!}
@endsection

@section('header')

<header class="Offer__header">

    {!! $header !!}

    @if ($top->count())

    <div class="Offer__top">

        @foreach ($top as $top_item)

        <div class="Offer__topItem">

            {!! $top_item !!}

        </div>

        @endforeach

    </div>

    @endif

</header>

@endsection

@section('content')

<div class="Offer__outerWrapper">

    <div class="Offer__innerWrapper">

        <div class="Offer__contentTop">

            {!! $content_top !!}

        </div>

        @if ($content->count())

        <main class="Offer__content">

            @foreach ($content as $content_item)

            <div class="Offer__contentItem">

                {!! $content_item !!}

            </div>

            @endforeach

        </main>

        @endif

        @if ($bottom->count())

        <section class="Offer__bottom">

            @foreach ($bottom as $bottom_item)

            <div class="Offer__bottomItem">

                {!! $bottom_item !!}

            </div>

            @endforeach

        </section>

        @endif

    </div>

</div>

@endsection

@section('footer')

<footer class="Offer__footer">

    {!! $footer !!}

</footer>

@endsection