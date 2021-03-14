@php
    $background = $background ?? '';
    $navbar = $navbar ?? '';
    $content = $content ?? [];
@endphp

<div class="HeaderMain {{ $isclasses }}"
     style="background-image: linear-gradient(
             rgba(0, 0, 0, 0.3),
             rgba(0, 0, 0, 0.1),
             rgba(0, 0, 0, 0.2),
             rgba(0, 0, 0, 0.4)
             ), url({{ $background }});
             ">
    <div class="container">

        <div class="HeaderMain__navbar">

            {!! $navbar !!}

        </div>

        <div class="HeaderMain__content">

            @foreach ($content as $content_item)

                <div class="HeaderMain__contentItem">

                    {!! $content_item !!}

                </div>

            @endforeach

        </div>

    </div>

</div>