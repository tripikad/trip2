<?php

namespace App\Http\Controllers;

use Request;
use Response;

class V2UtilsController extends Controller
{
    
    public function format()
    {
        $body = Request::input('body');

        return Response::json([
            'body' => format_body($body),
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
