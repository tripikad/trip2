@if (isset($route) && $route != '')
    <a href="{{ $route }}"
       @if (isset($target) && $target != '')
           target="{!! $target !!}"
       @endif
       class="c-link {{ $modifiers or '' }}">
@else
    <span class="c-link {{ $modifiers or '' }}">
@endif
    {{ $title }}
    @if(isset($icon))
        <span class="c-link__icon">
            @include('component.svg.sprite', [
                'name' => $icon
            ])
        </span>
    @endif

@if (isset($route) && $route != '')
    </a>
@else
    </span>
@endif
