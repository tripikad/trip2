@php

$content = $content ?? collect();

@endphp

<div class="Container {{ $isclasses }}">

    <div class="Container__wrapper">

    @foreach ($content as $content_item)
                    
        <div class="Container__contentItem">

            {!! $content_item !!}

        </div>
            
    @endforeach

    </div>

</div>
