<header {{ $attributes->merge(['class' => 'Header Header--' . $type]) }}>
    <div class="container-lg">

        <x-navbar type="{{$navBarType}}"/>

        <div class="Header__content">

            {{$slot}}

        </div>
    </div>
</header>