@php

$title = $title ?? '';
$name = $name ?? '';
$value = $value ?? '';
$placeholder = $placeholder ?? '';

@endphp

<div class="FormTextfield {{ $isclasses }}">

    @if ($title)

        <label for="{{ $name }}" class="FormTextfield__label">{{ $title }}</label>
    
    @endif

    <input
        class="FormTextfield__input"
        id="{{ $name }}"
        name="{{ $name }}"
        type="text"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
    >

</div>