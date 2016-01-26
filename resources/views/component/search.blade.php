@inject('request', 'Illuminate\Http\Request')

<div class="c-search {{ $modifiers or '' }}">

    <div class="c-search__form">

    {!! Form::open(['url' => '/search', 'method' => 'get', 'id' => 'global_search_form']) !!}

        <span class="c-search__form-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-search'
            ])

        </span>

        {!! Form::input('search', 'q', $request->input('q'), [
             'class' => 'c-search__form-input',
             'id' => 'global_search_input'
        ]) !!}

        {!! Form::close() !!}
      
    </div>
    <div id="search_results_div"></div>
</div>
