@php

$items = $items ?? collect();

@endphp

<div class="row">

@foreach ($items as $row)
            
    <div class="col-4">

        {!! $row !!}

    </div>

@endforeach
    
</div>
