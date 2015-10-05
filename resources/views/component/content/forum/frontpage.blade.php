@if (count($contents) > 0)

@include('component.subheader', [
    'title' => trans('frontpage.index.forum.title'),
    'link_title' => '',
    'link_route' => '',
    'options' => '-padding -orange',
])

<div class="utils-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Featured forum posts will go here',
        'height' => 160
    ])

</div>

@endif