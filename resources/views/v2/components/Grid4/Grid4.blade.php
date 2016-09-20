@php

$items = collect($items) ?? collect();
$gutter = $gutter ?? false;
@endphp

@foreach ($items->chunk(4) as $row)
    
<div class="row">
        
    <div class="col-3

        @if ($gutter)

            padding-right-xs-mobile-none padding-bottom-sm

        @endif

    ">

        {!! $row->shift() !!}

    </div>
    
    <div class="col-3
    
        @if ($gutter)
        
            padding-left-sm-mobile-none padding-right-xs-mobile-none padding-bottom-sm

        @endif

    ">
    
        {!! $row->shift() !!}
    
    </div>

    <div class="col-3
    
        @if ($gutter)
        
            padding-left-sm-mobile-none padding-right-xs-mobile-none padding-bottom-sm

        @endif

    ">
    
        {!! $row->shift() !!}
    
    </div>

    <div class="col-3

        @if ($gutter)

            padding-left-sm-mobile-none padding-bottom-md

        @endif

    ">
    
        {!! $row->shift() !!}
    
    </div>
    
</div>

@endforeach