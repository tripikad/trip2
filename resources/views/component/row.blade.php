<div class="component-row {{ $options or '' }}">

    <div class="row utils-equal-height">

        <div class="
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                col-xs-2 col-sm-1 col-sm-offset-1 col-lg-offset-2
            @else 
                col-xs-2 col-sm-1 col-lg-offset-1
            @endif
        ">

            @if (isset($image_link)) <a href="{{ $image_link }}"> @endif

            @if (isset($image))
                
                @if (isset($options) && strpos($options, '-small') !== false) 

                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                        @include('component.user.image', [
                            'image' => $image,
                            'options' => '-circle',
                        ])
                        </div>
                    </div>
        
                @else 

                    @include('component.user.image', [
                        'image' => $image,
                        'options' => '-circle',
                    ])

                @endif

            @endif
             
            @if (isset($image_link)) </a> @endif

        </div>

        <div class="
            content
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                col-xs-7 col-sm-8 col-lg-6
            @else 
                col-xs-7 col-sm-10 col-lg-8
            @endif
        ">
            <div>

                <div class="title">

                    @if (isset($preheading)) <span>{!! $preheading !!}</span> @endif

                    @if (isset($heading_link)) <a href="{{ $heading_link }}"> @endif
                
                    @if (isset($heading)) <h3>{{ $heading }}</h3> @endif

                    @if (isset($heading_link)) </a> @endif

                    @if (isset($postheading)) <span>{!! $postheading !!}</span> @endif


                </div>

                @if (isset($text)) <div class="text">{!! $text !!}</div> @endif

                @if (isset($actions)) <div class="actions">{!! $actions !!}</div> @endif

            </div>

        </div>

        <div class="
            content
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                col-xs-3 col-sm-1 col-lg-1
            @else 
                col-xs-3 col-sm-1 col-lg-1
            @endif
        ">
     
            {!! $extra or '' !!}

        </div>

    </div>

    @if (isset($body))

        <div class="row">

            <div class="
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                    col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3
                @else 
                    col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2
                @endif
            ">

                {!! $body !!}

            </div>

        </div>

    @endif

</div>
