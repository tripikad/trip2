<div class="row">
    
    <div class="col-xs-3 col-xs-offset-3 col-sm-1 col-sm-offset-5">
    
        @include('component.circle', [
            'number' => $content_count,
            'options' => '-empty'
        ])

    </div>

    <div class="col-xs-3 col-xs-offset-0 col-sm-1 col-sm-offset-0">
    
        @include('component.circle', [
            'number' => $comment_count,
            'options' => '-empty'
        ])

    </div>

</div>