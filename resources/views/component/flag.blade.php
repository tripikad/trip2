{{--

title: Flag

code: |

    @include('component.flag', [
        'number' => '12',
        'modifiers' => $modifiers
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

--}}

<div class="c-flag {{ $modifiers or 'm-yellow' }}">

    <div class="c-flag__item">

        <div class="c-flag__item-text">{{ $number or '0'}}</div>
    </div>
</div>