@php

$navbar = $navbar ?? '';
$content = $content ?? [];

@endphp

<div class="HeaderLight {{ $isclasses }}">

    <div class="container padding-bottom-none-mobile-sm">

        <div class="HeaderLight__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="HeaderLight__content">

            @foreach ($content as $content_item)
        
            <div class="HeaderLight__contentItem">

                {!! $content_item !!}
                    
            </div>

            @endforeach

        </div>

    </div>
    
</div>
