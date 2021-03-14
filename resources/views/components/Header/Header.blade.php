<header {{ $attributes->merge(['class' => 'Header Header--' . $type]) }}
        style="background-image: linear-gradient(
        rgba(0, 0, 0, 0.3),
        rgba(0, 0, 0, 0.1),
        rgba(0, 0, 0, 0.2),
        rgba(0, 0, 0, 0.4)
        ), url({{ $backgroundImage }});
        ">
    <div class="container-lg">

        <x-navbar type="{{$navBarType}}"/>

        <div class="Header__content">

            {{$slot}}

        </div>
    </div>
</header>