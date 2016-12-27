@php

$background = $background ?? '';
$navbar = $navbar ?? '';
$header = $header ?? '';
$title = $title ?? '';

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

            <div class="row row-center">

                <div class="col-10">
                
                    <div class="Header__title">

                    {!! $title !!}

                    </div>

                </div>

            </div>

        </div>

    </div>
    
</div>
