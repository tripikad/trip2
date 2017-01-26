@php

$id = $id ?? '';
$user = $user ?? '';
$title = $title ?? '';
$route = $route ?? '';

@endphp

<h3 class="MessageRow {{ $isclasses }}">

    <a id="message-{{ $id }}"></a>

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

</h3>

