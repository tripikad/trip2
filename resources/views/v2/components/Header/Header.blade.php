@php

$background = $background ?? '';
$navbar = $navbar ?? '';
$content = collect($content) ?? collect();

@endphp

<header class="Header {{ $isclasses }}"
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.4),
      rgba(0, 0, 0, 0.1),
      rgba(0, 0, 0, 0.2)
    ), url({{ $background }});
">
    <div class="container">

        <div class="Header__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="Header__content">

        @foreach ($content as $content_item)
        
        <div @if (! $loop->last) class="margin-bottom-md" @endif>

            {!! $content_item !!}
                
        </div>

        @endforeach

        </div>

    </div>
    
</header>
