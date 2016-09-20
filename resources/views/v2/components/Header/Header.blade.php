@php

$background = $background ?? '';
$navbar = $navbar ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="Header {{ $isclasses }}" 
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.2),
      rgba(0, 0, 0, 0)
    ), url({{ $background }});
">
    <div class="container">

        <div class="Header__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="Header__content">

            <div>
                
                <div class="Header__title">

                {!! $title !!}

                </div>

                <div class="Header__meta">

                {!! $meta !!}

                </div>

            </div>

        </div>

    </div>
    
</div>
