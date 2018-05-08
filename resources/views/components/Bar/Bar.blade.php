@php

$content = $content ?? collect();

@endphp

<div class="Bar {{ $isclasses }}">
    
    @foreach ($content as $content_item)
                    
        <div class="Bar__item">

            {!! $content_item !!}

        </div>
            
    @endforeach

</div>
