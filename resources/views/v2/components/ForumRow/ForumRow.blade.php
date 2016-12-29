@php

$route = $route ?? '';
$user = $user ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();
$badge = $badge ?? '';

@endphp

<div class="ForumRow {{ $isclasses }}">

    <div class="ForumRow__left">

        {!! $user !!}

    </div>

    <div class="ForumRow__right">

        <div>

            <a href="{{ $route }}">

            <div class="ForumRow__title">

                {{ $title }}

            </div>

            <div class="ForumRow__meta">

                {!! $meta !!}
            
            </div>

            </a>

        </div>

    </div>

</div>