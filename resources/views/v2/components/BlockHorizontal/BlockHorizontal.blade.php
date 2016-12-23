@php

$content = collect($content) ?? collect();

@endphp

<div class="BlockHorizontal {{ $isclasses }}">

    @foreach ($content as $content_item)

        <div class="BlockHorizontal__item">

        {!! $content_item !!}
        
        </div>

    @endforeach

</div>