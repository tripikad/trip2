{{--

description: Promo / Ad

code: |

    @include('component.promo', [
        'route' => '',
        'image' => '',
    ])

--}}

<div class="c-promo">

    <a href="{{ $route }}" class="c-promo__link">
        <img src="{{ $image }}" alt="" class="c-promo__image">
    </a>
</div>