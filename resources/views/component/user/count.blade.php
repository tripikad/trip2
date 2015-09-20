<div class="row">
    
    <div class="col-xs-3 col-xs-offset-3 col-sm-1 col-sm-offset-5 text-center">
    
        @include('component.number', [
            'number' => $content_count,
            'text' => 'Posts',
            'options' => '-border -large'
        ])

        <p>{{ trans('user.show.count.content.title') }}</p>

    </div>

    <div class="col-xs-3 col-xs-offset-0 col-sm-1 col-sm-offset-0 text-center">
    
        @include('component.number', [
            'number' => $comment_count,
            'options' => '-border -large'
        ])

        <p>{{ trans('user.show.count.comment.title') }}</p>
    
    </div>

</div>