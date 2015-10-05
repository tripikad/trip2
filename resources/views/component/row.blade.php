<div class="component-row {{ $options or '' }}">

    <div class="row utils-equal-height">

        <div class="col-xs-2 col-sm-1 utils-half-padding-right">

            @if (isset($image_link)) <a href="{{ $image_link }}"> @endif

            @if (isset($image))
                
                @include('component.user.image', [
                    'image' => $image,
                    'options' => '-circle',
                ])

            @endif
             
            @if (isset($image_link)) </a> @endif

        </div>

        <div class="col-xs-8 col-sm-9">

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

        <div class="col-sm-2">
     
            {!! $extra or '' !!}

        </div>

    </div>

    @if (isset($body))

        <div class="row">

            <div class="col-sm-11 col-sm-offset-1">

                {!! $body !!}

            </div>

        </div>

    @endif

</div>
