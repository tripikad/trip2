@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.blog.title') }}</h3>

<div class="utils-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Featured blogs will go here',
        'height' => 160
    ])

</div>

@endif