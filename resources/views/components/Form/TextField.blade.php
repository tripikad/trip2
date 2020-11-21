<div {{ $attributes->merge(['class' => 'FormTextfield' . ($errors->has($name) ? ' FormTextField--error' : '')])}}>

    <div class="FormTextField__header">

        <label for="{{ $name }}" class="FormTextField__label">{{ $label }}</label>

    </div>

    <div class="FormTextField__field">

        <input class="FormTextField__input"
               id="{{ $name }}"
               name="{{ $name }}"
               type="{{ $type }}"
               value="{{ $value ?? old($name) }}"
               placeholder="{{ $placeholder }}"
               spellcheck="false"
               @if($disabled) disabled @endif />

    </div>

</div>