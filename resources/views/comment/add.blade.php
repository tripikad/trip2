<hr />

<div class="row">

    <div class="col-xs-2 col-sm-1">

        @include('image.circle', ['image' => 'http://trip.ee/files/pictures/picture_none.png'])

    </div>

    <div class="col-xs-9 col-sm-10">

        @include('component.placeholder', ['text' => 'Comment form', 'height' => 200])

        <div class="row">
            <div class="col-sm-6">
                @include('component.placeholder', ['text' => 'Follow post'])
            </div>
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">
                @include('component.placeholder', ['text' => 'Add comment'])
            </div>
        </div>
    </div>

    <div class="col-sm-1">

    </div>

</div>
