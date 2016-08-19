@php

$route = $route ?? '';
$image = $image ?? '';
$profile = $profile ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="TravelmateCard {{ $isclasses }}"> 
                
        @if ($image)
        
        <div class="TravelmateCard__image"
            style="background-image: url({{ $image }});"
        >     
        </div>
        
        @endif

        <div class="TravelmateCard__profile">

            {!! $profile !!}

        </div>

        <a href="{{ $route }}">

            <div class="TravelmateCard__title">

                {{ $title }}

            </div>

        </a>

        <div class="TravelmateCard__meta">

            {!! $meta !!}
        
        </div>

</div>