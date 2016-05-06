{{--

title: Promo / Ad

code: |

    @include('component.promo', [
        'modifiers' => '',
        'route' => '',
        'image' => '',
    ])

modifiers:

- m-sidebar-large
- m-sidebar-small
- m-footer
- m-body

--}}


@if (isset($promo) && $promo)
    <div id="{{ config("promo.$promo.id2") }}" class="c-promo {{ (isset($modifiers) && $modifiers ? $modifiers : 'm-'.$promo)  }}" style="display: none;"></div>
@else
    <div class="c-promo {{ $modifiers or '' }}">
        <a href="{{ $route }}" class="c-promo__link">
            <img src="{{ $image }}" alt="" class="c-promo__image">
        </a>
    </div>
@endif
