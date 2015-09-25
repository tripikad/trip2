{!! Form::open([
    'url' => route('admin.image.store'),
    'files' => true
]) !!}

    <div class="form-group">
            
        {!! Form::file('image') !!}
        
        {!! Form::submit(trans('admin.image.create.submit.title'), [
            'class' => 'btn btn-primary'
        ]) !!}
        
    </div>           

{!! Form::close() !!}
