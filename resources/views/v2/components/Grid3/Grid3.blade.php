@php

$items = collect($items) ?? collect();
$gutter = $gutter ?? false;

@endphp

@foreach ($items->chunk(3) as $row)
    
<div class="row">
    
    @foreach ($row as $item)

    <div
        class="col-4 show-mobile-desktop margin-bottom-none-mobile-sm
        @if ($gutter) padding-right-sm-mobile-none @endif
    ">

        {!! $item !!}

    </div>
    
    @endforeach
    
</div>

@endforeach

@foreach ($items->withoutLastWhenOdd()->chunk(2) as $row)
    
<div class="row">
    
    @foreach ($row as $item)

    <div
        class="col-6 show-tablet margin-bottom-none-mobile-sm
        @if ($gutter) padding-right-sm-mobile-none @endif
    ">

        {!! $item !!}

    </div>
    
    @endforeach
    
</div>

@endforeach