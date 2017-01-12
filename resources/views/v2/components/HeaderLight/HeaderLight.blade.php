@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$content = $content ?? collect();
$background = $background ?? ''

@endphp

<div class="HeaderLight {{ $isclasses }}">

    <div class="container">

        <div class="HeaderLight__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="HeaderLight__content">
                
                @foreach ($content as $content_item)
                
                <div @if (!$loop->last) class="margin-bottom-md" @endif>

                    {!! $content_item !!}
                        
                </div>

                @endforeach

        </div>

    </div>

    {!! $background !!}
    
</div>
