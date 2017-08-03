@php

	$name = $name ?? '';
	$value = $value ?? '';
	$title = $title ?? '';

@endphp
<div class="FormCheckbox {{ $isclasses }}">

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        @if ($value) checked @endif
        class="FormCheckbox__checkbox" 
    >

    <label for="{{ $name }}" class="FormCheckbox__label">{{ $title }}</label>

</div>