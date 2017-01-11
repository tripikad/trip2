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
                
                <div class="HeaderLight__titleWrapper">
                
                    <div class="HeaderLight__title">

                    {!! $title !!}

                    </div>
                
                    <div class="HeaderLight__meta2">

                    

                    </div>

                </div>

                @if ($meta || $meta2)

                <div class="HeaderLight__metaWrapper">

                    <div class="HeaderLight__meta2">

                    {!! $meta2 !!}

                    </div>

                    <div class="HeaderLight__meta">

                    {!! $meta !!}

                    </div>

                </div>

                @endif

        </div>

    </div>

    {!! $background !!}
    
    
</div>
