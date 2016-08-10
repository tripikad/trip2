<?php
/*
title: Card

code: |

    #include('component.card', [
        'image' => \App\Image::getRandom(),
        'route' => '',
        'title' => 'Here is title',
        'text' => 'Here is subtitle',
        'modifiers' => $modifiers,
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple
- m-small
- m-wrap-text
- m-text-small
- m-text-gray
*/
?>

<div class="c-card {{ $modifiers or '' }}">

    <div class="c-card__bg"

         @if(isset($image))

            style="background-image: url({{ $image }});"

         @endif

         ></div>

    @if (isset($route))

    <a href="{{ $route }}" class="c-card__link">

    @endif

    <div class="c-card__content">

        @if (isset($title))

        <h3 class="c-card__title">{{ $title }}</h3>

        @endif

        @if (isset($text))

        <p class="c-card__text">{!! $text !!}</p>

        @endif

    </div>

    @if (isset($route))

    </a>

    @endif

</div>
