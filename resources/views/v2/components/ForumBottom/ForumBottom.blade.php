@php

$left_items = $left_items ?? '';
$right_items = $right_items ?? '';

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

    	<div class="ForumBottom__item">
    		
    		{!! $right_item !!}

    	</div>  

    @endforeach

    </div>

</div>
