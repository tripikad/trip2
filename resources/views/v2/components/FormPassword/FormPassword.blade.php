@php

$title = $title ?? '';
$name = $name ?? '';
$value = $value ?? '';
$placeholder = $placeholder ?? '';

@endphp

<div class="FormPassword {{ $isclasses }}">

    @if ($title)

        <label for="{{ $name }}" class="FormPassword__label">{{ $title }}</label>
    
    @endif

    <input
        class="FormPassword__input"
        id="{{ $name }}"
        name="{{ $name }}"
        type="password"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
    >

</div>