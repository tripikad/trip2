@php

$id = $id ?? 0;
$user = $user ?? '';
$meta = $meta ?? collect();
$body = $body ?? '';

@endphp

<a id="comment-{{ $id }}">

<div class="Comment {{ $isclasses }}">

    <div class="Comment__left">

        {!! $user !!}

    </div>

    <div class="Comment__right">

        <div class="Comment__meta">

            {!! $meta !!}

        </div>

        <div class="Comment__body">

            {!! $body !!}

        </div>

    </div>

</div>

</a>