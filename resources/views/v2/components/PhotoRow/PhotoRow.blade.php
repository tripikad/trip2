@php

$title = $title ?? '';
$content = collect($content) ?? collect();

@endphp

<div class="PhotoRow {{ $isclasses }}">

    @if ($content->count())

        @foreach ($content as $content_item)

            {!! $content_item !!}
                
        @endforeach

    @endif

</div>
