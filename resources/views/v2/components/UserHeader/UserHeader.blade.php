@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';
$wanttogo = $wanttogo ?? '';
$actions_with_user = $actions_with_user ?? '';
$actions_by_user = $actions_by_user ?? '';
$background = $background ?? '';

@endphp

<div class="UserHeader {{ $isclasses }}">

    <div class="container">

        <div class="UserHeader__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="UserHeader__contentWrapper">

            <div class="UserHeader__user">

                {!! $user !!}

            </div>

            <div>

                <div class="UserHeader__nameWrapper">

                    <div class="UserHeader__name">

                        {!! $name !!}

                    </div>

                </div>

                <div class="UserHeader__actionsWithUser">

                    {!! $actions_with_user !!}

                </div>

            </div>

        </div>

        <div class="UserHeader__meta">

            {!! $meta !!}

        </div>

        <div class="UserHeader__wanttogo">

            {!! $wanttogo !!}

        </div>
        
        <div class="UserHeader__stats">

            {!! $stats !!}

        </div>

        @if ($actions_by_user)
        
        <div class="UserHeader__actionsByUser">

            {!! $actions_by_user !!}

        </div>

        @endif

    </div>

    {!! $background !!}

</div>
