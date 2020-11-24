<header {{ $attributes->merge(['class' => 'Header Header--' . $type]) }}>
    <div class="container">

        <x-navbar type="{{$navBarType}}"/>

        <div class="Header__content">

            {{$slot}}

        </div>
    </div>
</header>