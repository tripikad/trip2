@php

$route = $route ?? '';
$title = $title ?? '';
$icon = $icon ?? 'icon-arrow-right';

@endphp

<a href="{{ $route }}">
	
    <div class="LinkBarSmall {{ $isclasses }}">

	    <div class="LinkBarSmall__title">
	      
            {{ $title }}
	        
	    </div>

        <div class="LinkBarSmall__icon">

            {!! component('Icon')->is('gray')->with('icon', $icon) !!}

        </div>

	</div>

</a>
