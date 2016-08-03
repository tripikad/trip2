<?php

namespace App\Http\Controllers;

use App;
use Request;
use Storage;

class StyleguideController extends Controller {

    public function index() {

        return view('v2.layouts.1col')
            ->with('content', collect()
                ->push(component('Arc'))
                ->push(component('Button')->with('title', 'Button'))
            );

    }

}