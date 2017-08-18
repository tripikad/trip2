@php

    $name = $name ?? '';
    $value = $value ?? '';
    $placeholder = $placeholder ?? '';

@endphp

    <div class="FormSearchField">
        <input type="text" autocomplete="off" placeholder="{{ $placeholder }}" class="FormSearchField__input" name="{{ $name }}" value="{{ $value }}">

        <div class="FormSearchField__icon">
            <component is="Icon" icon="icon-search" size="lg"></component>
        </div>
    </div>
