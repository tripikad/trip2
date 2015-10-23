{{--

title: Badge

code: |

    @include('component.badge', [
        'modifiers' => $modifiers,
        'count' => 4
    ])

modifiers:

- m-inverted

--}}

<div class="c-badge {{ $modifiers or '' }}">
	{{ $count }}
</div>