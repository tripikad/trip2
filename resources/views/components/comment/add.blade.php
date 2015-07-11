<div class="row">

    <div class="col-sm-1">
    </div>

    <div class="col-sm-10">

        <div class="form-group">

            {!! Form::open(array('url' => 'content/' . $content->id . '/comment')) !!}

            <div class="form-group">
            
                {!! Form::textarea('body', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => 'Comment',
                    'rows' => 5
                ]) !!}
            
            </div>

            <div class="row">

                <div class="col-md-8">
                </div>

                <div class="col-md-4">
                
                    {!! Form::submit('Add comment', [
                        'class' => 'btn btn-primary btn-md btn-block'
                    ]) !!}
                    
                </div>

            </div>

            {!! Form::close() !!}
        
        </div>
    
    </div>

    <div class="col-sm-1">
    </div>

</div>
