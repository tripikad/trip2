@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="HeaderLight {{ $isclasses }}">

    <div class="container">

        <div class="HeaderLight__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="HeaderLight__content">

            <div>
                
                <div class="HeaderLight__title">

                {!! $title !!}

                </div>

                <div class="HeaderLight__meta">

                {!! $meta !!}

                </div>

            </div>

        </div>

    </div>

        <div class="HeaderLight__background" style="background-image: url({{ $background }})"></div>

    
</div>
