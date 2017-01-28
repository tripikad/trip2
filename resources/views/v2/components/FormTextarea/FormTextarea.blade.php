@php

$title = $title ?? '';
$name = $name ?? '';
$value = $value ?? '';
$rows = $rows ?? 8;
$cols = $cols ?? 50;
$placeholder = $placeholder ?? '';

@endphp

<div class="FormTextarea {{ $isclasses }}">

    @if ($title)

        <label for="{{ $name }}" class="FormTextarea__label">{{ $title }}</label>
    
    @endif

    <textarea
        class="FormTextarea__textarea"
        id={{ $name }}
        name="{{ $name }}"
        rows="{{ $rows }}"
        cols="{{ $cols }} "
        placeholder="{{ $placeholder }}"
    >{{ $value }}</textarea>

</div>