<div {{ $attributes->merge(['class' => 'FormTextarea' . ($errors->has($name) ? ' FormTextField--error' : '')])}}>

    <div class="FormTextField__header">
        <label for="{{ $name }}" class="FormTextField__label">
            {{ $label }}
        </label>
    </div>

    <textarea
            class="FormTextarea__textarea"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            rows="{{ $rows }}">{{ old($name, $value) }}
    </textarea>

</div>