@php

$user = $user ?? '';
$title = $title ?? '';
$route = $route ?? '';
$body = $body ?? '';

@endphp

<div class="MessageRow {{ $isclasses }}">

    <div class="MessageRow__user">

        {!! $user !!}

    </div>

    <div>

        @if ($route)

        <a href="{{ $route }}">

        @endif

            <div class="MessageRow__title">

                {{ $title }}

            </div>

        @if ($route)

        </a>

        @endif

    </div>

</div>

@if ($body)

    <div class="MessageRow__body">

    {!! $body !!}

    </div>

@endif

