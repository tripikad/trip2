@php

$background = $background ?? '';
$navbar = $navbar ?? '';
$header = $header ?? '';
$search = $search ?? '';

@endphp

<div class="FrontpageHeader {{ $isclasses }}" 
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.4),
      rgba(0, 0, 0, 0.1),
      rgba(0, 0, 0, 0.2)
    ), url({{ $background }});
">
    <div class="container">

        <div class="FrontpageHeader__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="FrontpageHeader__content">
                
            <div class="FrontpageHeader__search">

            {!! $search !!}

            </div>

        </div>

    </div>
    
</div>
