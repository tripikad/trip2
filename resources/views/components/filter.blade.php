<div class="text-center">

{!! Form::open([
    'url' => route('content.filter', [$type]),
    'class' => 'form-inline'
]) !!}

<div class="form-group">

    {!! Form::select(
        'destination',
        $destinations, 
        $destination, 
        ['class' => 'form-control input-sm']
    )!!}

</div>

<div class="form-group">

    {!! Form::select(
        'topic',
        $topics, 
        $topic, 
        ['class' => 'form-control input-sm']
    )!!}

</div>

<div class="form-group">

{!! Form::submit(
    trans('content.filter.submit.title'), 
    ['class' => 'btn btn-primary btn-sm btn-block'])
!!}

</div>

<div class="form-group">

<a 
    href="{{ route('content.index', [$type]) }}"
    class="btn btn-default btn-sm btn-block"
>

{{ trans('content.filter.reset.title') }}

</a>

</div>

</div>

 {!! Form::close() !!}