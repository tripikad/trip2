@php

$profile = $profile ?? '';
$meta = $meta ?? '';
$body = $body ?? '';

@endphp

<div class="Comment {{ $isclasses }}">

    <div class="Comment__left">

        {!! $profile !!}

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