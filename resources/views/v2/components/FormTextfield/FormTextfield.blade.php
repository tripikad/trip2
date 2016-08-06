@php

$label = $label ?? '';
$name = $name ?? '';
$value = $value ?? '';

@endphp

<div class="FormTextfield {{ $isclasses }}">

    @if ($label)

        <label for="{{ $name }}" class="FormTextfield__label">{{ $label }}</label>
    
    @endif

    <input class="FormTextfield__title" name="{{ $name }}" type="text" value="{{ $value }}">

</div>