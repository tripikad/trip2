<div class="row">
    
    <div class="col-xs-5 col-xs-offset-3 col-sm-2 col-sm-offset-6 utils-padding-right text-center">
    
        @include('component.number', [
            'number' => $content_count,
            'text' => 'Posts',
            'options' => '-large -neutral'
        ])

        <p>{{ trans('user.show.count.content.title') }}</p>

    </div>

    <div class="col-xs-5 col-xs-offset-0 col-sm-2 col-sm-offset-0 utils-padding-left text-center">
    
        @include('component.number', [
            'number' => $comment_count,
            'options' => '-large -neutral'
        ])

        <p>{{ trans('user.show.count.comment.title') }}</p>
    
    </div>

</div>