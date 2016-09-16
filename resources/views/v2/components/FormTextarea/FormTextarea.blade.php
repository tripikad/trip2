@php

$label = $label ?? '';
$name = $name ?? '';
$value = $value ?? '';
$rows = $rows ?? 8;
$cols = $cols ?? 50;
$placeholder = $placeholder ?? '';

@endphp

<div class="FormTextarea {{ $isclasses }}">

    @if ($label)

        <label for="{{ $name }}" class="FormTextarea__label">{{ $label }}</label>
    
    @endif

    <textarea
        class="FormTextarea__textarea"
        id={{ $name }}
        name="{{ $name }}"
        rows="8"
        cols="50"
        placeholder="{{ $placeholder }}"
    >{{ $value }}</textarea>

</div>