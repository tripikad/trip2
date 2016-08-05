@php

$route = $route ?? false;
$title = $title ?? false;
$icon = $icon ?? 'icon-arrow-right';

@endphp

<a href="{{ $route }}">
	
    <div class="Link {{ $isclasses }}">

	    <div class="Link__title">
	      
            {{ $title }}
	        
	    </div>

        {!! component('Icon')->is('gray')->with('icon', $icon) !!}

	</div>

</a>
