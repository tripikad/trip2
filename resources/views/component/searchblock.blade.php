@if($results)

    <div class="c-search__results-content">

        @foreach($results as $type => $content)

            @if(isset($results[$type]) && $results[$type])

                 @include('component.search.results.ajax.'.$type, [
                            'content' => $results[$type]
                        ]) 

            @endif 

        @endforeach

    </div>

    <footer class="c-search__results-footer">
        @include('component.link', [
            'modifiers' => 'm-icon',
            'title' => 'Kõik tulemused ('.$total_cnt.')',
            'route' => '/search?q='.$q,
            'icon' => 'icon-arrow-right'
        ])
    </footer>

@endif        