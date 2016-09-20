@php

$left_items = collect($left_items) ?? collect();
$right_items = collect($right_items) ?? collect();

@endphp

<div class="row">

    <div class="col-3">

    @foreach ($left_items as $left_item)
    
    	<div class="margin-bottom-md">
    		
    		{!! $left_item !!}

    	</div>

    @endforeach

    </div>

    <div class="col-9">

    @foreach($right_items as $right_item)

        <div class="margin-bottom-md">
    		
    		{!! $right_item !!}

    	</div>  

    @endforeach

    </div>

</div>
