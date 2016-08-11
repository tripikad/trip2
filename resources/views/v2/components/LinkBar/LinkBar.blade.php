@php

$route = $route ?? '';
$title = $title ?? '';
$icon = $icon ?? 'icon-arrow-right';

@endphp

<a href="{{ $route }}">
	
    <div class="LinkBar {{ $isclasses }}">

	    <div class="LinkBar__title">
	      
            {{ $title }}
	        
	    </div>

        <div class="LinkBar__icon">

            {!! component('Icon')->is('gray')->with('icon', $icon) !!}

        </div>

	</div>

</a>
