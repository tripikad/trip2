@php

$route = $route ?? '';
$figure = $figure ?? '';
$title = $title ?? '';
$subtitle = $subtitle ?? '';
$tags = $tags ?? collect();

@endphp

<a href="{{ $route }}">

<div class="ForumItem {{ $isclasses }}">

    <div class="ForumItem__left">

        {!! $figure !!}

    </div>

    <div class="ForumItem__right">

        <div>

            <div class="ForumItem__title">

                {{ $title }}

            </div>

            <div class="ForumItem__subtitle">

                {!! $subtitle !!}

                {!! $tags !!}

            </div>

        </div>

    </div>

</div>

</a>