@php

$profile = $profile ?? '';
$route = $route ?? '';
$title = $title ?? '';
$badge = $badge ?? '';

@endphp

<div class="ForumRowSmall {{ $isclasses }}">

	<div class="ForumRowSmall__profile">

    	{!! $profile !!}

    </div>

    <a href="{!! $route !!}">

	    <div class="ForumRowSmall__title">

	        {{ $title }}

	    </div>

        <div class="ForumRowSmall__meta">

            {!! $meta !!}

        </div>

    </a>

    <div class="ForumRowSmall__badge">

    {!! $badge !!}

    </div>

</div>