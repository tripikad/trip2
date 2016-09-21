@php

$items = collect($items) ?? collect();
$gutter = $gutter ?? false;
@endphp

@foreach ($items->chunk(3) as $row)
    
<div class="row">
    
    @foreach ($row as $item)

    <div
        class="col-4 margin-bottom-none-mobile-sm
        @if ($gutter) padding-right-sm-mobile-none @endif
    ">

        {!! $item !!}

    </div>
    
    @endforeach
    
</div>

@endforeach