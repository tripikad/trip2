<a href="{{ $route }}" class="c-link {{ $modifiers or '' }}">
    {{ $title }}
    @if(isset($icon))
        <span class="c-link__icon">
            @include('component.svg.sprite', [
                'name' => $icon
            ])
        </span>
    @endif
</a>
