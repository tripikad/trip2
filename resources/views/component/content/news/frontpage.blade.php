@if (count($contents) > 0)

<div class="row utils-double-padding-bottom">

        <div class="col-sm-6">

            @if (isset($content[0]))

            <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                @include('component.card', [
                    'image' => $contents[0]->imagePath(),
                    'title' => $contents[0]->title,
                    'options' => '-landscape-padding'
                ])
                    
            </a>

            @endif

        </div>

        <div class="col-sm-6">

            <div class="row">

                <div class="col-sm-6 utils-padding-bottom">
                    
                    @if (isset($content[1]))

                    <a href="{{ route('content.show', [$contents[1]->type, $contents[1]]) }}">

                        @include('component.card', [
                            'image' => $contents[1]->imagePath(),
                            'text' => $contents[1]->title,
                            'options' => '-landscape'
                    ])
                
                    </a>

                    @endif

                </div>

                <div class="col-sm-6 utils-padding-bottom">

                    @if (isset($content[2]))

                    <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                        @include('component.card', [
                            'image' => $contents[2]->imagePath(),
                            'text' => $contents[2]->title,
                            'options' => '-landscape'
                    ])
                
                    </a>

                    @endif

                </div>

            </div>

            <div class="row">

                <div class="col-sm-6 utils-padding-bottom">

                    @if (isset($content[3]))

                    <a href="{{ route('content.show', [$contents[1]->type, $contents[1]]) }}">

                        @include('component.card', [
                            'image' => $contents[3]->imagePath(),
                            'text' => $contents[3]->title,
                            'options' => '-landscape'
                    ])
                
                    </a>

                    @endif

                </div>

                <div class="col-sm-6 utils-padding-bottom">

                    @if (isset($content[4]))

                    <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                        @include('component.card', [
                            'image' => $contents[4]->imagePath(),
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