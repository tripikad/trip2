@php

$items = $items ?? [];
$gutter = $gutter ?? false;

@endphp

@foreach (collect($items)->chunk(2) as $row)
    
<div class="row">
        
    <div class="col-6 @if ($gutter) padding-right-sm-mobile-none padding-bottom-md @endif">

        {!! $row->shift() !!}

    </div>
    
    <div class="col-6 @if ($gutter) padding-left-sm-mobile-none padding-bottom-md @endif">
    
        {!! $row->shift() !!}
    
    </div>
    
</div>

@endforeach