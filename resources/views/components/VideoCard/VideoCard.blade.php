@php

    $image = $image ?? '';
    $title = $title ?? '';
    $meta = $meta ?? '';
    $embed = $embed ?? false;
    $route = $route ?? false;

@endphp


    <div class="VideoCard {{ $isclasses }}">

        <div class="VideoCard__metaContainer padding-bottom-md">

            <div class="VideoCard__user">

                {!! $user !!}

            </div>

            <div class="VideoCard__content">

                <a href="{{ $route }}">

                    <div class="VideoCard__title">

                        {{ $title }}

                    </div>

                </a>

                <div class="VideoCard__meta">

                    {!! $meta !!}

                </div>

            </div>

        </div>

        <div class="VideoCard__image padding-bottom-sm">

            @if ($embed)
                <iframe
                        src="https://www.youtube.com/embed/MJ2KTtpw_U8">
                </iframe>
            @else
                <a href="{{ $route }}">
                    {{--<img src="{{ $thumbnailImgUrl }}" style="width: 100%">--}}
                    <img src="https://img.youtube.com/vi/MJ2KTtpw_U8/0.jpg">
                </a>
            @endif

        </div>

    </div>