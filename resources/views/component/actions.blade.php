{{--

title: Actions

code: |

    @include('component.actions', [
        'actions' => [
            ['route' => '', 'title' => 'First'],
            ['route' => '', 'title' => 'Second'],
            ['route' => '', 'title' => 'Third']
        ]
    ])

--}}

@if (count($actions))

<div class="c-actions">

    @foreach($actions as $action)

        {!! Form::open([
            'url' => $action['route'],
            'method' => isset($action['method']) ? $action['method'] : 'GET',
            'class' => 'c-actions__form m-inline'
        ]) !!}

        {!! Form::submit($action['title'], [
            'class' => 'c-actions__link'
        ]) !!}

        {!! Form::close() !!}

    @endforeach

</div>

@endif