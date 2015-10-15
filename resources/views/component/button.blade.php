{{--

description: Button component

code: |

    @include('component.button', [
        'title' => 'Button',
        'route' => '',
        'buttontype' => 'btn-default'
    ])

--}}

<a href="{{ $route }}" class="btn {{ $buttontype or 'btn-primary' }}">{{ $title }}</a>