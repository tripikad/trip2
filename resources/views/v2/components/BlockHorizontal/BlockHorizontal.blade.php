@php

$content = $content ?? collect();

@endphp

<div class="BlockHorizontal {{ $isclasses }}">

    @foreach ($content as $content_item)

        @if ($content_item)

        <div class="BlockHorizontal__item">

        {!! $content_item !!}
        
        </div>

        @endif

    @endforeach

</div>