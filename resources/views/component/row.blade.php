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
                
                <div
                
                @if (isset($options) && strpos($options, '-small') !== false) 

                    style="width: 60%;"

                @else 

                    style="width: 80%;"

                @endif
                
                >
                
                    @include('component.user.image', [
                        'image' => $image,
                        'options' => '-circle',
                    ])

                </div>

            @endif
             
            @if (isset($image_link)) </a> @endif

        </div>

        <div class="
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                col-xs-11 col-sm-12 col-lg-10
            @else 
                col-xs-11 col-sm-14 col-lg-12
            @endif
        ">
            <div class="content">

                <div class="title">

                    @if (isset($preheading)) <span>{!! $preheading !!}</span> @endif

                    @if (isset($heading_link)) <a href="{{ $heading_link }}"> @endif
                
                    @if (isset($heading)) <h4>{{ $heading }}</h4> @endif

                    @if (isset($heading_link)) </a> @endif

                    @if (isset($postheading)) <span>{!! $postheading !!}</span> @endif


                </div>

                @if (isset($description)) <div class="text">{!! $description !!}</div> @endif

                @if (isset($actions)) <div class="actions">{!! $actions !!}</div> @endif

            </div>

        </div>

        <div class="
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
                    col-sm-12 col-sm-offset-2 col-lg-10 col-lg-offset-3
                @else 
                    col-sm-14 col-sm-offset-1 col-lg-12 col-lg-offset-2
                @endif
            ">

                {!! $body !!}

            </div>

        </div>

    @endif

</div>
