@if (count($contents) > 0)

<div class="row utils-double-padding-bottom">

        <div class="col-sm-6">

            @if (isset($contents[0]))

            <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                @include('component.card', [
                    'image' => $contents[0]->images()->first()->preset('medium'),
                    'title' => $contents[0]->title,
                    'options' => '-landscape-padding'
                ])
                    
            </a>

            @endif

        </div>

        <div class="col-sm-6">

            <div class="row">

                <div class="col-sm-6 utils-padding-bottom">
                    
                    @if (isset($contents[1]))

                    <a href="{{ route('content.show', [$contents[1]->type, $contents[1]]) }}">

                        @include('component.card', [
                            'image' => $contents[1]->images()->first()->preset(),
                            'text' => $contents[1]->title,
                            'options' => '-landscape'
                    ])
                
                    </a>

                    @endif

                </div>

                <div class="col-sm-6 utils-padding-bottom">

                    @if (isset($contents[2]))

                    <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                        @include('component.card', [
                            'image' => $contents[2]->images()->first()->preset(),
                            'text' => $contents[2]->title,
                            'options' => '-landscape'
                    ])
                
                    </a>

                    @endif

                </div>

            </div>

            <div class="row">

                <div class="col-sm-6 utils-padding-bottom">

                    @if (isset($contents[3]))

                    <a href="{{ route('content.show', [$contents[1]->type, $contents[1]]) }}">

                        @include('component.card', [
                            'image' => $contents[3]->images()->first()->preset(),
                            'text' => $contents[3]->title,
                            'options' => '-landscape'
                    ])
                
                    </a>

                    @endif

                </div>

                <div class="col-sm-6 utils-padding-bottom">

                    @if (isset($contents[4]))

                    <a href="{{ route('content.show', [$contents[0]->type, $contents[0]]) }}">

                        @include('component.card', [
                            'image' => $contents[4]->images()->first()->preset(),
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