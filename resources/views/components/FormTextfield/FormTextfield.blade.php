@php

$title = $title ?? '';
$name = $name ?? '';
$value = $value ?? '';
$size = $size ?? '';
$placeholder = $placeholder ?? '';
$disabled = $disabled ?? false;

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
        size="{{ $size }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if($disabled)
        disabled
        @endif
    >

</div>