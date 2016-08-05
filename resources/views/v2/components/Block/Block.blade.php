@php

$title = $title ?? false;
$subtitle = $subtitle ?? false;
$content = $content ?? collect();

@endphp

<div class="Block {{ $isclasses }}">

    @if ($title)

    <div class="Block__title">

        {{ $title }}

    </div>

    @endif

    @if ($subtitle)

    <div class="Block__subtitle">

        {{ $subtitle }}

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