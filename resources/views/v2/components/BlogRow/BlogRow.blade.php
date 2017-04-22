@php

$user = $user ?? '';
$title = $title ?? '';
$route = $route ?? '';
$meta = $meta ?? '';

@endphp

<h3 class="BlogRow {{ $isclasses }}">

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

</h3>
