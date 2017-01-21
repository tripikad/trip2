@php

$left_content = collect($left_content) ?? collect();
$right_content = collect($right_content) ?? collect();
$left_col = $left_col ?? 7;
$right_col = $right_col ?? 4;

@endphp

<div class="row row-between">

    <div class="col-{{ $left_col }}">

    @foreach ($left_content as $left_content_item)
    
        <div @if (! $loop->last) class="margin-bottom-md" @endif>
            
            {!! $left_content_item !!}

        </div>

    @endforeach

    </div>

    <div class="col-{{ $right_col }} padding-top-none-mobile-md">

    @foreach ($right_content as $right_content_item)
    
        <div @if (! $loop->last) class="margin-bottom-md" @endif>
            
            {!! $right_content_item !!}

        </div>

    @endforeach

    </div>

</div>
