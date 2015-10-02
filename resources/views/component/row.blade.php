<div class="component-row {{ $options or '' }}">

    <div class="row utils-equal-height">

        <div class="col-xs-1 utils-half-padding-right">

            @if (isset($image_link)) <a href="{{ $image_link }}"> @endif

            @if (isset($image))
                
                @include('component.user.image', [
                    'image' => $image,
                    'options' => '-circle',
                ])

            @endif
             
            @if (isset($image_link)) </a> @endif

        </div>

        <div class="
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                col-sm-10
            @else 
                col-sm-10
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
                col-sm-1
            @else 
                col-sm-1
            @endif
        ">
     
            {!! $extra or '' !!}

        </div>

    </div>

    @if (isset($body))

        <div class="row">

            <div class="
            @if (isset($options) && strpos($options, '-narrow') !== false) 
                    col-sm-11 col-sm-offset-1
                @else 
                    col-sm-11 col-sm-offset-1
                @endif
            ">

                {!! $body !!}

            </div>

        </div>

    @endif

</div>
