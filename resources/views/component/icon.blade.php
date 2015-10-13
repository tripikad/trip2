{{--

A SVG icon

@include('component.icon', ['icon' => 'iconname'])
    
--}}

<span class="component-icon {{ $options or '' }}">

    <svg width="64" height="64">
        <use xlink:href="/svg/main.svg#{{ $icon }}"></use>
    </svg>

</span>