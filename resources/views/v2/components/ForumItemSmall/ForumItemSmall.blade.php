@php

$profile = $profile ?? '';
$route = $route ?? '';
$title = $title ?? '';
$time = $time ?? '';
$badge = $badge ?? '';

@endphp



    <div class="ForumItemSmall {{ $isclasses }}">

    	<div class="ForumItemSmall__Profile">

        	{!! $profile !!}

        </div>

        <a href="{!! $route !!}">

            <div class="ForumItemSmall__info">

        	    <div class="ForumItemSmall__title">

        	        {{ $title }}

        	    </div>

                <div class="ForumItemSmall__time">

                    {{ $time }}

                </div>

            </div>

        </a>

        <div class="ForumItemSmall__badge">

        {!! $badge !!}

        </div>
    </div>

