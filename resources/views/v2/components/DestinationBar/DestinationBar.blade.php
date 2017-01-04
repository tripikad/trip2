@php

$route = $route ?? '';
$title = $title ?? '';
$parents = $parents ?? '';

@endphp

<div class="DestinationBar {{ $isclasses }}">

    <div>
                    
            <div class="DestinationBar__parents">

                {!! $parents  !!}

            </div>

            <a href="{{ $route }}">

                <div class="DestinationBar__title">

                    {{ $title }} ›

                </div>

            </a>

    </div>

</div>
