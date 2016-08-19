@php

$items = $items ?? collect();

@endphp

@foreach ($items->chunk(2) as $row)
    
<div class="row">
        
    <div class="col-6 padding-right-sm-mobile-none padding-bottom-md">

        {!! $row->shift() !!}

    </div>
    
    <div class="col-6 padding-left-sm-mobile-none padding-bottom-md">
    
        {!! $row->shift() !!}
    
    </div>
    
</div>

@endforeach