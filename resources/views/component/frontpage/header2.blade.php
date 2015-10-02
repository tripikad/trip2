<div class="component-frontpage-header-2">

    <div class="container">
        
        <div class="row">
        
                <div class="col-sm-4">

                    @include('component.destination.subheader', [
                        'title' => $random_destination,
                        'title_route' => '',
                        'text' => $random_destination,
                        'text_route' => '',
                        'options' => '-orange'
                    ])

                    @include('component.card', [
                        'image' => $random_image,
                        'title' => 'Crazy offer to ' . $random_destination,
                        'options' => '-center -wide',
                    ])

                </div>

                <div class="col-sm-4">

                    @include('component.destination.subheader', [
                        'title' => $random_destination2,
                        'title_route' => '',
                        'text' => $random_destination2,
                        'text_route' => '',
                        'options' => '-green'
                    ])

                    @include('component.card', [
                        'image' => $random_image2,
                        'title' => 'Crazy offer to ' . $random_destination2,
                        'options' => '-center -wide',
                    ])

                </div>

                <div class="col-sm-4">

                    @include('component.destination.subheader', [
                        'title' => $random_destination3,
                        'title_route' => '',
                        'text' => $random_destination3,
                        'text_route' => '',
                        'options' => '-red'
                    ])

                    @include('component.card', [
                        'image' => $random_image3,
                        'title' => 'Crazy offer to ' . $random_destination3,
                        'options' => '-center -wide',
                    ])

                </div>

        </div>
    
    </div>

</div>