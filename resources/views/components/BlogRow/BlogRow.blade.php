@php

$user = $user ?? '';
$title = $title ?? '';
$route = $route ?? '';
$meta = $meta ?? '';

@endphp

<div class="BlogRow {{ $isclasses }}">

    <div class="BlogRow__user">

        {!! $user !!}

    </div>

    <div>

        @if ($route)

        <a href="{{ $route }}">

        @endif

            <div class="BlogRow__title">

                {{ $title }}

            </div>

        @if ($route)

        </a>

        @endif

        <div class="BlogRow__meta">

            {!! $meta !!}

        </div>

    </div>

</div>
