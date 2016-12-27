@php

$background = $background ?? '';
$navbar = $navbar ?? '';
$header = $header ?? '';
$title = $title ?? '';

@endphp

<div class="FrontpageHeader {{ $isclasses }}" 
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.2),
      rgba(0, 0, 0, 0)
    ), url({{ $background }});
">
    <div class="container">

        <div class="FrontpageHeader__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="FrontpageHeader__content">

            <div class="row row-center">

                <div class="col-10">
                
                    <div class="FrontpageHeader__title">

                    {!! $title !!}

                    </div>

                </div>

            </div>

        </div>

    </div>
    
</div>
