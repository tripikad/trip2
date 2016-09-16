@php

	$name = $name ?? '';
	$checked = $checked ?? '';
	$label = $label ?? '';

@endphp
<div class="FormCheckbox {{ $isclasses }}">

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        @if ($checked) checked @endif
        class="FormCheckbox__checkbox" 
    >

    <label for="{{ $name }}" class="FormCheckbox__label">{{ $label }}</label>

</div>