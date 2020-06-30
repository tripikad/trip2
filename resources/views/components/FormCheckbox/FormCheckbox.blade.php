@php

	$name = $name ?? '';
	$value = $value ?? '';
	$title = $title ?? '';
	$disabled = $disabled ?? false;

@endphp
<div class="FormCheckbox {{ $isclasses }}">

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        @if ($value) checked @endif
        class="FormCheckbox__checkbox" 
        dusk="{{ slug($title) }}"
        @if ($disabled) disabled="disabled" @endif
    >

    <label for="{{ $name }}" class="FormCheckbox__label">{{ $title }}</label>

</div>