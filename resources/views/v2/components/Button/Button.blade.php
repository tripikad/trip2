@php

$route = $route ?? '';
$title = $title ?? '';

@endphp

<a href="{{ $route }}">

    <div class="Button {{ $isclasses }}">

        <div class="Button__title">

            {{ $title }}

        </div>

    </div>

</a>
