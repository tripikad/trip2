@php

    $image = $image ?? '';
    $logo = $logo ?? '';
    $links = $links ?? [];
    $licence = $licence ?? '';

@endphp

<div
    class="Footer {{ $isclasses }}"
    style="
        background-image: linear-gradient(
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.5)
        ),
    url({{ $image }});"
>    
    <div class="container">

        <div class="Footer__wrapper">
    
            <div class="Footer__col">
                
                {!! $logo !!}

            </div>

            @foreach(['col1', 'col2', 'col3'] as $col)

            <div class="Footer__col">

                @foreach($links[$col] as $link)
                
                <a href="{{ $link->route }}"><div class="Footer__link">{{ $link->title }}</div></a>

                @endforeach

            </div>

             @endforeach

        </div>

        <div class="Footer__social">

            @foreach($links['social'] as $link)
            
            <a href="{{ $link->route }}" target="{{ $link->target }}">

                {!! $link->icon !!}

                <span class="Footer__socialLink">{{ $link->title }}</span>

            </a>

            @endforeach
        
        </div>

        <div class="Footer__licence">

            {!! $licence !!}
        
        </div>

    </div>

</div>
