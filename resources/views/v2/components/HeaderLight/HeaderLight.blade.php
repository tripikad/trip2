@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';
$background = $background ?? '';

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

                @if ($meta)

                <div class="HeaderLight__meta">

                {!! $meta !!}

                </div>

                @endif

            </div>

        </div>

    </div>

    {!! $background !!}
    
    
</div>
