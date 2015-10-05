{!! Form::open([
    'url' => route('frontpage.search'),
    'class' => 'form-inline'
]) !!}

<div class="row">

    <div class="col-sm-5 col-sm-offset-3 utils-half-padding-right">
    
    {!! Form::select(
        'destination',
        ['' => trans('frontpage.index.search.destination.title')]
             + $destinations->toArray()

    )!!}
    
    </div>

    <div class="col-sm-1">
    
    {!! Form::submit(
        trans('frontpage.index.search.submit.title'), 
        ['class' => 'btn btn-primary btn-sm btn-block'])
    !!}

    </div>

</div>

{!! Form::close() !!}