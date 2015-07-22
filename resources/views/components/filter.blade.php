<hr />

{!! Form::open([
    'url' => route('content.filter', [$type]),
    'class' => 'form-inline'
]) !!}

<div class="row">

    <div class="col-sm-3 col-sm-offset-3">

        {!! Form::select(
            'destination',
            ['' => trans('content.index.filter.field.destination.title')]
                 + $destinations->toArray(),
            $destination
        )!!}

    </div>

    <div class="col-sm-3">

        {!! Form::select(
            'topic',
            ['' => trans('content.index.filter.field.topic.title')]
                 + $topics->toArray(), 
            $topic
        )!!}

    </div>

    <div class="col-sm-1">

    {!! Form::submit(
        trans('content.index.filter.submit.title'), 
        ['class' => 'btn btn-primary btn-sm btn-block'])
    !!}

    <a 
        href="{{ route('content.index', [$type]) }}"
        class="btn btn-link"
    >

    {{ trans('content.index.filter.reset.title') }}

    </a>

    </div>

</div>

{!! Form::close() !!}

@if ($destination)
    
    <hr />
    
    <h3>
        {!! trans('content.index.filter.destination.title', [
            'destination' => 
                '<a href="' . route('destination.index', [$destination]) . '">'
                . $destinations[$destination]
                . '</a>'
        ]) !!}
    </h3>

@endif

<hr />
