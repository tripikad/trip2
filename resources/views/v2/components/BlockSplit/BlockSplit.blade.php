@php

$content_left = collect($content_left) ?? collect();
$content_right = collect($content_right) ?? collect();

@endphp

<div class="row row-between">

    <div class="col-7">

    @foreach ($content_left as $content_left_item)
    
        <div @if (! $loop->last) class="margin-bottom-md" @endif>
            
            {!! $content_left_item !!}

        </div>

    @endforeach

    </div>

    <div class="col-4">

    @foreach ($content_right as $content_right_item)
    
        <div @if (! $loop->last) class="margin-bottom-md" @endif>
            
            {!! $content_right_item !!}

        </div>

    @endforeach

    </div>

</div>
