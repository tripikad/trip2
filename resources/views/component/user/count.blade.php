<div class="row">
    
    <div class="col-xs-2 col-sm-offset-4">
    
        @include('component.number', [
            'number' => $content_count,
            'text' => 'Posts'
        ])

    </div>

    <div class="col-xs-2">
    
        @include('component.number', [
            'number' => $comment_count,
            'text' => 'Comments'
        ])

    </div>

</div>