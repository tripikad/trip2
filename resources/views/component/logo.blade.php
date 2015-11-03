{{--

title: Logo

description: By default the logo is white, use m-dark to get a darker logo

code: |

    @include('component.logo', [
        'modifiers' => $modifiers,
    ])

modifiers:

- m-dark

--}}

<div class="c-logo {{ $modifiers or '' }}">

    @if ($modifiers === 'm-dark')

    <img src="/svg/tripee_logo_dark.svg" alt="">

    @else

    <img src="/svg/tripee_logo.svg" alt="">

    @endif
</div>