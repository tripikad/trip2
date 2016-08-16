@php

$background = $background ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

 <a href="{{ $route }}">

<div class="NewsCard {{ $isclasses }}" 
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0),
      rgba(0, 0, 0, 0.3)
    ), url({{ $background }});">

    <div>

        <div class="NewsCard__title">

            {{ $title }}

        </div>

        <div class="NewsCard__meta">

            {!! $meta !!}
        
        </div>

        </a>

    </div>

</div>