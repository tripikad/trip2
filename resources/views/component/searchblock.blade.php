@if(isset($results) && $results)
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
            'modifiers' => $footer_modifier,
            'title' => trans('search.results.all').' ('.$total_cnt.')',
            'route' => '/search?q='.$q,
            'icon' => 'icon-arrow-right'
        ])
    </footer>
@elseif (isset($not_found) && $not_found)
    <div class="c-search__results-content">
        <p>{{ $not_found }}</p>
    </div>
@endif
