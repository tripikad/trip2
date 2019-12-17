@php

$title = $title ?? '';
$description = $description ?? '';
$name = $name ?? '';
$value = $value ?? '';
$rows = $rows ?? 8;
$cols = $cols ?? 50;
$placeholder = $placeholder ?? '';
$disabled = $disabled ?? false;

@endphp

<div class="FormTextarea {{ $isclasses }} {{ $errors->first($name) ? 'FormTextfield--error' : ''}}">

    <div class="FormTextfield__header">

        @if ($title)

        <label for="{{ $name }}" class="FormTextfield__label">{{ $title }}</label>

        @endif

        @if ($description)

        <div class="FormTextfield__description">{{ $description }}</div>

        @endif

    </div>

    <textarea class="FormTextarea__textarea" id={{ $name }} name="{{ $name }}" rows="{{ $rows }}" cols="{{ $cols }} "
        placeholder="{{ $placeholder }}" dusk="{{ slug($title) }}" @if($disabled) disabled
        @endif>{{ $value }}</textarea>

</div>