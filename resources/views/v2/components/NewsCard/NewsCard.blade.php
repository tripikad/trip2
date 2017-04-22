@php

$image = $image ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

 <a href="{{ $route }}">

<h3 class="NewsCard {{ $isclasses }}">

    <div
        class="NewsCard__image"
        style="background-image: url({{ $image }});"
    >
    
    </div>

    <h3 class="NewsCard__title">

        {{ $title }}

    </h3>

    <div class="NewsCard__meta">

        {!! $meta !!}
    
    </div>

</h3>

</a>
