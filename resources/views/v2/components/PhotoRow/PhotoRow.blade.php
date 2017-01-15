@php

$title = $title ?? '';
$content = collect($content) ?? collect();

@endphp

<div class="PhotoRow {{ $isclasses }}">

    @if ($content->count())

        <div class="PhotoRow__photo">

        @foreach ($content as $content_item)

            {!! $content_item !!}
                
        @endforeach

        </div>

    @endif

</div>
