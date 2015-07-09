<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;


class AdController extends Controller
{

    public function index()
    {

        return view('pages.ad.index');

    }

}