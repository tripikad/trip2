<div class="c-masthead__nav m-previous">
    @if (isset($nav_previous_route) && $nav_previous_route != '')
        <a href="{{ $nav_previous_route }}" class="c-link {{ $modifiers or '' }}">
            @if (isset($nav_previous_title))
                &lsaquo; {{ $nav_previous_title }}
            @endif
        </a>
    @endif
</div>
<div class="c-masthead__nav m-next">
    @if (isset($nav_next_route) && $nav_next_route != '')
        <a href="{{ $nav_next_route }}" class="c-link {{ $modifiers or '' }}">
            @if (isset($nav_next_title))
            {{ $nav_next_title }} &rsaquo;
            @endif
        </a>
    @endif
</div>