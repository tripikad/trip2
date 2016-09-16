@php

$title = $title ?? false;
$content = $content ?? collect();

@endphp

<div class="Block {{ $isclasses }}">

    @if ($title)

    <div class="Block__title">

        {{ $title }}

    </div>

    @endif

    <div class="Block__content">

        @foreach ($content->withoutLast() as $content_item)
    
            <div class="margin-bottom-sm">

            {!! $content_item !!}
            
            </div>

        @endforeach

        <div>

            {!! $content->last() !!}
            
        </div>

    </div>

</div>