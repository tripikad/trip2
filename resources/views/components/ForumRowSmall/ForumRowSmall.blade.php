@php

$user = $user ?? '';
$route = $route ?? '';
$title = $title ?? '';
$badge = $badge ?? '';

@endphp

<div class="ForumRowSmall {{ $isclasses }}">

	<div class="ForumRowSmall__user">

    	{!! $user !!}

    </div>

    <div>
        
        <a href="{!! $route !!}">

    	    <div class="ForumRowSmall__title">

    	        {{ $title }}

    	    </div>

        </a>

        <div class="ForumRowSmall__meta">

            {!! $meta !!}

        </div>

    </div>

</div>