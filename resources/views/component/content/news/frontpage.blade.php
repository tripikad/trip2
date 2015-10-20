@if (count($contents) > 0)

@include('component.subheader', [
    'title' => trans('frontpage.index.news.title'),
    'link_title' => '',
    'link_route' => '',
    'options' => '-padding -orange',
])

<div class="row utils-padding-bottom">

        <div class="col-sm-6">

            @if (isset($contents[0]))

            <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                @include('component.card', [
                    'image' => $contents[0]->imagePreset('medium'),
                    'title' => $contents[0]->title,
                ])

            </a>

            @endif

        </div>

        <div class="col-sm-6">

            <div class="row">

                <div class="col-sm-6">

                    @if (isset($contents[1]))

                    <a href="{{ route('content.show', [$contents[1]->type, $contents[1]]) }}">

                        @include('component.card', [
                            'image' => $contents[1]->imagePreset(),
                            'text' => $contents[1]->title,
                            'options' => '-landscape'
                    ])

                    </a>

                    @endif

                </div>

                <div class="col-sm-6">

                    @if (isset($contents[2]))

                    <a href="{{ route('content.show', [$contents[2]->type, $contents[2]]) }}">

                        @include('component.card', [
                            'image' => $contents[2]->imagePreset(),
                            'text' => $contents[2]->title,
                            'options' => '-landscape'
                    ])

                    </a>

                    @endif

                </div>

            </div>

            <div class="row">

                <div class="col-sm-6">

                    @if (isset($contents[3]))

                    <a href="{{ route('content.show', [$contents[3]->type, $contents[3]]) }}">

                        @include('component.card', [
                            'image' => $contents[3]->imagePreset(),
                            'text' => $contents[3]->title,
                            'options' => '-landscape'
                    ])

                    </a>

                    @endif

                </div>

                <div class="col-sm-6">

                    @if (isset($contents[4]))

                    <a href="{{ route('content.show', [$contents[4]->type, $contents[4]]) }}">

                        @include('component.card', [
                            'image' => $contents[4]->imagePreset(),
                            'text' => $contents[4]->title,
                            'options' => '-landscape'
                    ])

                    </a>

                    @endif

                </div>

            </div>

        </div>

</div>

@endif