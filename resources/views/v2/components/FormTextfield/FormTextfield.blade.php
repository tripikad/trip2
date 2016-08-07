@php

$label = $label ?? '';
$name = $name ?? '';
$value = $value ?? '';
$placeholder = $placeholder ?? '';

@endphp

<div class="FormTextfield {{ $isclasses }}">

    @if ($label)

        <label for="{{ $name }}" class="FormTextfield__label">{{ $label }}</label>
    
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