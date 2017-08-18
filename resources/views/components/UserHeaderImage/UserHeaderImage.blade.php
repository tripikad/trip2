@php

$user = $user ?? '';
$title = $title ?? '';
$actions = $actions ?? '';

@endphp

<div class="UserHeaderImage {{ $isclasses }}">

    <div class="UserHeaderImage__user">

        {!! $user !!}

    </div>

    <div class="UserHeaderImage__content">
        
        <div class="UserHeaderImage__title">

            {!! $title !!}

        </div>

        <div class="UserHeaderImage__actions">

            {!! $actions !!}

        </div>

    </div>

</div>
