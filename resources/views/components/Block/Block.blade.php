@php

$title = $title ?? '';
$route = $route ?? '';
$content = isset($content) ? collect($content) : collect();

@endphp

<div class="Block {{ $isclasses }}">

    @if ($title)

    <div class="Block__title">

    {!! component('BlockTitle')->with('title', $title)->with('route', $route) !!}

    </div>

    @endif

    <div class="Block__content">

        @foreach ($content as $content_item)
    
            <div class="Block__contentItem">

            {!! $content_item !!}
            
            </div>

        @endforeach

    </div>

</div>