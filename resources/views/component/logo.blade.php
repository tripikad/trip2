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

    @if(isset($modifiers))

        @if($modifiers === 'm-small')

        <img src="/V1dist/tripee_logo_plain.svg" alt="">

        @elseif($modifiers === 'm-small m-dark' || $modifiers === 'm-dark m-small')

        <img src="/V1dist/tripee_logo_plain_dark.svg" alt="">

        @elseif($modifiers === 'm-dark')

        <img src="/V1dist/tripee_logo_dark.svg" alt="">

        @else

        <img src="/V1dist/tripee_logo.svg" alt="">

        @endif

    @else

        <img src="/V1dist/tripee_logo.svg" alt="">

    @endif

</div>