@extends('layouts.one_column')

@section('title', 'Styleguide')

@section('content.one')

<div class="c-styleguide">

@if (count($components)) 

    @foreach($components as $component)

        <div class="c-styleguide__component">

            <div class="left">

                <p>{!! $component['description'] !!}</p>
                
                <pre>// {{ $component['title'] }}

{{ str_replace('@', '&#64;', htmlentities($component['code'])) }}

                </pre>
                        
            </div>

            <div class="right">

                @if ($component['title'] == 'views/component/icon.blade.php')

                        @foreach($icons as $icon)
                            <a title="{{ $icon }}">
                                @include('component.icon', ['icon' => $icon])
                            </a>
                        @endforeach

                @elseif (isset($component['options']))

                    @foreach($component['options'] as $option)

                        <code>{{ $option }}</code>

                        <br /><br />

                        {!! \StringView::make([
                            'template' => $component['code'],
                            'cache_key' => str_random(10),
                            'updated_at' => 0
                        ], ['options' => "$option"]) !!}

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