@php

$id = $id ?? 0;
$profile = $profile ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();
$body = $body ?? '';

@endphp

<div class="ForumPost {{ $isclasses }}">

    <div class="ForumPost__title">

        {!! $title !!}

    </div>

    <div class="ForumPost__content">

        <div class="ForumPost__left">

            {!! $profile !!}

        </div>

        <div class="ForumPost__right">

            <div class="ForumPost__meta">

                {!! $meta !!}

            </div>

            <div class="ForumPost__body">

                {!! $body !!}

            </div>

        </div>

    </div>

</div>