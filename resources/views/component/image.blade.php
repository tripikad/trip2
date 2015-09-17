<div class="
    component-image
    @if(isset($height) && $height == 'small') 
        -small
    @endif
    {{ $options or ''}}
">

    <img src="{{ $image }}" />

</div>