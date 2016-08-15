<?php

namespace App\Http\Controllers;

use Request;
use Response;

class V2UtilsController extends Controller
{
    public function alert()
    {
        return Response::json([
            'info' => session('info'),
        ]);
    }

    public function format()
    {
        $body = Request::input('body');

        return Response::json([
            'body' => format_body($body),
        ]);
    }
}
