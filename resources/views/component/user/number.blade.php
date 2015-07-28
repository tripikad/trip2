<div class="row">
    
    <div class="col-xs-1 col-sm-offset-5">
    
        @include('component.number', [
            'number' => $number_forum,
            'text' => 'Posts'
        ])

    </div>

    <div class="col-xs-1">
    
        @include('component.number', [
            'number' => $number_comment,
            'text' => 'Comments'
        ])

    </div>

</div>