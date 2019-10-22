@php

$key = $key ?? '';
$value = $value ?? '';

@endphp

<div class="StyleSpacing">

    <div class="StyleSpacing__example">

        <div style="
            width: {{ $value }};
            height: {{ $value }};
        "></div>

    </div>

    <div class="StyleSpacing__title">

        {{ $key }} / {{ $value }}

    </div>

</div>