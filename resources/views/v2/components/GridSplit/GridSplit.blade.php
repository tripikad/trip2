@php

$content = $content ?? collect();
$sidebar = $sidebar ?? collect();

@endphp

<div class="row row-between">

    <div class="col-7">

    @foreach ($content as $content_item)
    
        <div class="margin-bottom-md">
            
            {!! $content_item !!}

        </div>

    @endforeach

    </div>

    <div class="col-4">

    @foreach ($sidebar as $sidebar_item)

        <div class="margin-bottom-md">
            
            {!! $sidebar_item !!}

        </div>  

    @endforeach

    </div>

</div>
