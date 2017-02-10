<?php

namespace App\Http\Controllers;

use Request;
use Response;

class V2UtilsController extends Controller
{
    public function format()
    {
        $value = Request::input('value');

        return Response::json([
            'value' => format_body($value),
        ]);
    }

    public function filter()
    {
        return redirect()->route(Request::get('type'), [
            'destination' => Request::get('destination'),
            'topic' => Request::get('topic'),
            'page' => Request::get('page'),
        ]);
    }
}
