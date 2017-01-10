@php

$image = $image ?? '';
$route = $route ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="NewsCard2 {{ $isclasses }}" 
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0) 0%,
      rgba(0, 0, 0, 0.3) 50%,
      rgba(0, 0, 0, 0.6) 100%
    ), url({{ $image }});">

    <a href="{{ $route }}">

    <div class="NewsCard2__wrapper">

    <div>

    <div class="NewsCard2__title">

        {{ $title }}

    </div>

    <div class="NewsCard2__meta">

        {!! $meta !!}

    </div>

    </div>

    </div>

    </a>

</div>
