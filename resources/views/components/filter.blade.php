<div class="component-filter text-center">

{!! Form::open([
    'url' => route('content.filter', [$type]),
    'class' => 'form-inline'
]) !!}

<div class="form-group">

    {!! Form::select(
        'destination',
        ['' => trans('content.index.filter.field.destination.title')]
             + $destinations->toArray(),
        $destination,
        ['class' => 'field-destination form-control input-sm']
    )!!}

</div>

<div class="form-group">

    {!! Form::select(
        'topic',
        ['' => trans('content.index.filter.field.topic.title')]
             + $topics->toArray(), 
        $topic, 
        ['class' => 'form-control input-sm']
    )!!}

</div>

<div class="form-group">

{!! Form::submit(
    trans('content.index.filter.submit.title'), 
    ['class' => 'btn btn-primary btn-sm btn-block'])
!!}

</div>

<div class="form-group">

<a 
    href="{{ route('content.index', [$type]) }}"
    class="btn btn-default btn-sm btn-block"
>

{{ trans('content.index.filter.reset.title') }}

</a>

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
</div>
