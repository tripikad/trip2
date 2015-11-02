{{--

title: Flag

code: |

    @include('component.footer', [
        'modifiers' => $modifiers,
        'image' => \App\Image::getRandom()
    ])

modifiers:

- m-bg

--}}

<footer class="c-footer {{ $modifiers or '' }}"
    @if (isset($image))
    style="background-image: url({{ $image }});"
    @endif
    >

    <div class="c-footer__wrap">

        <nav class="c-footer__nav">

            <a href="#" class="c-footer__nav-logo">Trip.ee</a>

            @include('component.footer.nav', [
                'menu' => 'footer',
                'items' => config('menu.footer')
            ])

            @include('component.footer.nav', [
                'menu' => 'footer2',
                'items' => config('menu.footer2')
            ])

            @include('component.footer.nav', [
                'menu' => 'footer3',
                'items' => config('menu.footer3')
            ])

        </nav>

        @include('component.footer.social', [
            'menu' => 'footer-social',
            'items' => config('menu.footer-social')
        ])

        <p class="c-footer__license">
            {{ trans('site.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
        </p>

    </div>

</footer>