<div {{ $attributes->merge(['class' => 'FormTextfield' . ($errors->has($name) ? ' FormTextField--error' : '')])}}>

    <div class="FormTextField__header">

        <label for="{{ $name }}" class="FormTextField__label">{{ $label }}</label>

    </div>

    <div class="FormTextField__field">

        <input class="FormTextField__input"
               id="{{ $name }}"
               name="{{ $name }}"
               type="{{ $type }}"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}"
               spellcheck="false"
               {{$attributes}}/>

    </div>

</div>