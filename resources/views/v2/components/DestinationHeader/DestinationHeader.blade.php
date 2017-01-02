@php

$navbar = $navbar ?? '';
$parents = $parents ?? '';
$title = $title ?? '';
$description = $description ?? '';
$facts1 = $facts1 ?? '';
$facts2 = $facts2 ?? '';
$stats = $stats ?? '';
$background = $background ?? '';

@endphp

<div class="DestinationHeader {{ $isclasses }}">

    <div class="container">

        <div class="DestinationHeader__navbar">

            {!! $navbar !!}
            
        </div>

        @if ($parents)

        <div class="DestinationHeader__parents">

            {!! $parents !!}

        </div>

        @endif

        <div class="DestinationHeader__title">

            {{ $title }}

        </div>

        <div class="DestinationHeader__contentWrapper">

            <div>
                
                <div class="DestinationHeader__description">

                    {{ $description }}

                </div>

                <div class="DestinationHeader__factsWrapper">

                    <div class="DestinationHeader__facts">

                        {!! $facts1 !!}

                    </div>

                    <div class="DestinationHeader__facts">

                        {!! $facts2 !!}

                    </div>

                </div>

            </div>

            <div class="DestinationHeader__stats">

                {!! $stats !!}

            </div>

        </div>

    </div>
    
    {!! $background !!}

</div>
