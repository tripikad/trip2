{!! Form::open(array('id' => 'message', 'url' => route('message.store', [$user_from, $user_to]))) !!}

<div class="c-form__group">

    {!! Form::textarea('body', null, [
        'class' => 'c-form__input m-high',
        'placeholder' => trans('message.create.field.body.title'),
        'rows' => 5
    ]) !!}
        
</div>

<div class="c-form__group m-no-margin m-right">

    {!! Form::submit(trans('message.create.submit.title'), [
        'class' => 'c-button m-small'
    ]) !!}

</div>

{!! Form::close() !!}