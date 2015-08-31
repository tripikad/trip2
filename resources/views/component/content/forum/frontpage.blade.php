@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.forum.title') }}</h3>

<div class="utils-double-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Featured forum posts will go here',
        'height' => 160
    ])

</div>

@endif