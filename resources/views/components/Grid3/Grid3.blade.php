@php

$items = $items ?? [];
$gutter = $gutter ?? false;

@endphp

@foreach (collect($items)->chunk(3) as $row)
    
<div class="row @if (!$gutter) no-gutters @endif">
    
    @foreach ($row as $item)

    <div
        class="col-md-4 col-12 show-mobile-desktop margin-bottom-sm
        @if ($gutter) padding-right-sm-mobile-none @endif
    ">

        {!! $item !!}

    </div>
    
    @endforeach
    
</div>

@endforeach

@foreach (collect($items)->withoutLastWhenOdd()->chunk(2) as $row)
    
<div class="row">
    
    @foreach ($row as $item)

    <div
        class="col-md-6 col-12 show-tablet margin-bottom-sm
        @if ($gutter) padding-right-sm-mobile-none @endif
    ">

        {!! $item !!}

    </div>
    
    @endforeach
    
</div>

@endforeach