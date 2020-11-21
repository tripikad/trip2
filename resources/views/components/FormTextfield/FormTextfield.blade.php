@php

$title = $title ?? '';
$description = $description ?? '';
$prefix = $prefix ?? '';
$suffix = $suffix ?? '';
$name = $name ?? '';
$value = $value ?? '';
$size = $size ?? '';
$placeholder = $placeholder ?? '';
$disabled = $disabled ?? false;

@endphp

<div class="FormTextField {{ $isclasses }} {{ $errors->first($name) ? 'FormTextField--error' : ''}}">


    <div class="FormTextField__header">

        @if ($title)

        <label for="{{ $name }}" class="FormTextField__label">{{ $title }}</label>

        @endif

        @if ($description)

        <div class="FormTextField__description">{{ $description }}</div>

        @endif

    </div>

    <div class="FormTextField__field">

        @if ($prefix)

        <div class="FormTextField__prefix">

            {{ $prefix }}

        </div>

        @endif

        <input class="FormTextField__input" id="{{ $name }}" name="{{ $name }}" type="text" size="{{ $size }}"
            value="{{ $value }}" placeholder="{{ $placeholder }}" dusk="{{ slug($title) }}" @if($disabled) disabled
            @endif>

        @if ($suffix)

        <div class="FormTextField__suffix">

            {{ $suffix }}

        </div>

        @endif

    </div>

</div>