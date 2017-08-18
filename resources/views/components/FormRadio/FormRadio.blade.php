@php

$options = $options ?? collect();
$name = $name ?? '';
$value = $value ?? '';

@endphp

<div class="FormRadio {{ $isclasses }}">

    @foreach($options as $option)

    <div class="FormRadio__option">

        <input
            class="FormRadio__input"
            type="radio"
            id="{{ $option['id'] }}"
            name="{{ $name }}"
            value="{{ $option['id'] }}"
            @if ($option['id'] == $value)
            checked="checked"
            @endif
        />

        <label
            class="FormRadio__label"
            for="{{ $option['id'] }}"
        >
            {{ $option['name'] }}
        </label>

    </div>

    @endforeach

</div>
