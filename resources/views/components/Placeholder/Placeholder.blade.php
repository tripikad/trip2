@php

$title = $title ?? 'Placeholder';
$height = $height ?? 14;

@endphp

<div class="Placeholder {{ $isclasses }}" style="height: calc({{ $height }} * {{ styleVars()->spacer }});">

    <div class="Placeholder__title">

        {{ $title }}

    </div>

</div>
