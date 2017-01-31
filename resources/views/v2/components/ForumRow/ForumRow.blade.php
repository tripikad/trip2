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

            <h3 class="ForumRow__title">

                {{ $title }}

            </h3>

            </a>

            <div class="ForumRow__meta">

                {!! $meta !!}
            
            </div>

        </div>

    </div>

</div>