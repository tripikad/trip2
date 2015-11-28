<a href="{{ $route }}" class="c-link {{ $modifiers or '' }}">
    {{ $title }}
    @if(isset($icon))
        <span class="c-link__icon">
            @include('component.icon', [
                'icon' => $icon
            ])
        </span>
    @endif
</a>