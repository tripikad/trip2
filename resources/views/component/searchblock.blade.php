@if($results)

    <div class="c-search__results-content">

        <div class="c-search__results-wrap">

        @foreach($results as $type => $content)

            @if(isset($results[$type]) && $results[$type])

                @if($type == 'forum' && $header_search)

                    @include('component.search.results.ajax.forum_small', [
                                'content' => $results[$type]
                            ])

                @else

                    @include('component.search.results.ajax.'.$type, [
                                'content' => $results[$type]
                            ])

                @endif         

            @endif 

        @endforeach

        </div>

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