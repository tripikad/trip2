{!! Form::open(array('url' => route('message.store', [$user_from, $user_to]))) !!}

<div class="form-group">

    {!! Form::textarea('body', null, [
        'class' => 'form-control input-md',
        'placeholder' => trans('message.create.field.body.title'),
        'rows' => 5
    ]) !!}
        
</div>

<div class="row">

    <div class="col-md-8">
    </div>

    <div class="col-md-4">

        {!! Form::submit(trans('message.create.submit.title'), [
            'class' => 'btn btn-primary btn-md btn-block'
        ]) !!}
                
    </div>

</div>

{!! Form::close() !!}