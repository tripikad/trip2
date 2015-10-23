@extends('layouts.one_column')

@section('title', 'Styleguide')

@section('content.one')

<div class="c-styleguide">

@if (count($components)) 

    @foreach($components as $component)

        <div class="c-styleguide__component">

            <div class="left">

                <p style="font-size: 1.5em; margin-bottom: 0.5em">
                    {{ $component['title'] }}
                </p>
                
                <p>{!! $component['description'] !!}</p>
                
                <pre>// {{ $component['filepath'] }}

{{ str_replace('@', '&#64;', htmlentities($component['code'])) }}

                </pre>
                        
            </div>

            <div class="right">

                @if ($component['filepath'] == 'views/component/icon.blade.php')

                        @foreach($icons as $icon)
                            <a title="{{ $icon }}">
                                @include('component.icon', ['icon' => $icon])
                            </a>
                        @endforeach

                @elseif (isset($component['modifiers']))

                    @foreach($component['modifiers'] as $modifier)

                        <code>{{ $modifier }}</code>

                        <br /><br />

                        {!! \StringView::make([
                            'template' => $component['code'],
                            'cache_key' => str_random(10),
                            'updated_at' => 0
                        ], ['modifiers' => $modifier]) !!}

                        <br />

                    @endforeach

                @else  


                    {!! \StringView::make([
                        'template' => $component['code'],
                        'cache_key' => str_random(10),
                        'updated_at' => 0
                    ]) !!}


                @endif

            </div>

        </div>

    @endforeach

@endif

@stop