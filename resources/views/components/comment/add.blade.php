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

            <div class="form-group">
            
                {!! Form::submit('Add comment', [
                    'class' => 'btn btn-primary btn-lg btn-block'
                ]) !!}
            
            </div>

            {!! Form::close() !!}
        
        </div>
    
    </div>

    <div class="col-sm-1">
    </div>

</div>
