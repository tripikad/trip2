@php

$count = $count ?? 0;
$route = $route ?? '#';
$user = $user ?? '';
$title = $title ?? '';
$time = $time ?? '';

@endphp



    <div class="ForumItemSmall {{ $isclasses }}">

    	<div class="ForumItemSmall__badge">
        	{!!
        		component('ProfileImage')
        	!!}
        </div>

        <a href="{!! $route !!}">

            <div class="ForumItemSmall__info">

        	    <div class="ForumItemSmall__title">

        	        {{ $title }}

        	    </div>

        	    <div class="ForumItemSmall__time">
        	    	{!! $time !!}
        	    </div>

            </div>

            <div class="ForumItemSmall__badge">
            	{!! component('badge')->with('title', $count) !!}
            </div>

        </a>

    </div>

