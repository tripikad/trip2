<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class StyleguideController extends Controller
{

    public function index()
    {

        return view('pages.styleguide.index');

    }

}