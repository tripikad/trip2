@php

$background = $background ?? '';
$navbar = $navbar ?? '';
$header = $header ?? '';
$search = $search ?? '';

@endphp

<div class="Header {{ $isclasses }}" 
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

            <div>
                
                <div class="Header__title">

                {!! $search !!}

                </div>

            </div>

        </div>

    </div>
    
</div>
