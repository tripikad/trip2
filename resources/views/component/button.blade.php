{{--

title: Button

code: |

    @include('component.button', [
        'title' => 'Button',
        'route' => '',
        'modifiers' => $modifiers
    ])

modifiers:

- m-block
- m-secondary
- m-large
- m-loading

--}}

<a href="{{ $route }}" class="c-button {{ $modifiers or '' }}">{{ $title }}</a>