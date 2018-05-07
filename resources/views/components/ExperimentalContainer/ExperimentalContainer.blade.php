@php

$content = $content ?? collect();

@endphp

<div class="ExperimentalContainer {{ $isclasses }}">

    @foreach ($content as $content_item)
                    
        <div class="ExperimentalContainer__contentItem">

            {!! $content_item !!}

        </div>
            
    @endforeach

</div>
