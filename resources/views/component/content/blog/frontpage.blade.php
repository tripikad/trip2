@if (count($contents) > 0)

@include('component.subheader', [
    'title' => trans('frontpage.index.blog.title'),
    'link_title' => '',
    'link_route' => '',
    'options' => '-padding -orange',
])

<div class="utils-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Featured blogs will go here',
        'height' => 160
    ])

</div>

@endif