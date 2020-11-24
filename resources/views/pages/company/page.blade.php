@extends('layouts.main2')

@section('content')

    <div class="page-company-page">
        <x-header
                type="light"
                navBarType="dark">
            <h3>{{$company->name}}</h3>
        </x-header>

        <x-footer type="light"/>
    </div>
@endsection<?php
