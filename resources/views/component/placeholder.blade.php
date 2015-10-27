{{--

title: Placeholder

description: Placeholder is meant for prototyping components not yet created. It accepts <code>height</code> parameter for specifying component height in pixels.

code: |
    
    @include('component.placeholder', [
        'text' => 'Placeholder',
        'height' => '200',
    ])

--}}

<div class="c-placeholder"

    @if (isset($height))
        style="height: {{ $height }}px;"
    @endif

>

    {{ $text }}

</div>
