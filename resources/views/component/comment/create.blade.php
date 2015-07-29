<div class="row">

    <div class="col-sm-1">
    </div>

    <div class="col-sm-10">

        <div class="form-group">

            {!! Form::open(array('url' => route('comment.store', [$content->type, $content->id]))) !!}

            <div class="form-group">
            
                {!! Form::textarea('body', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('comment.create.field.body.title'),
                    'rows' => 5
                ]) !!}
            
            </div>

            <div class="row">

                <div class="col-md-8">
                </div>

                <div class="col-md-4">
                
                    <div class="form-group">

                        {!! Form::submit(trans('comment.create.submit.title'), [
                        'class' => 'btn btn-primary btn-md btn-block'
                        ]) !!}
                    
                    </div>
                    
                </div>

            </div>

            {!! Form::close() !!}
        
        </div>
    
    </div>

    <div class="col-sm-1">
    </div>

</div>
