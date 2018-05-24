@php

$content = $content ?? collect();

@endphp

<div class="Container {{ $isclasses }}">

    @foreach ($content as $content_item)
                    
        <div class="Container__contentItem">

            {!! $content_item !!}

        </div>
            
    @endforeach

</div>
