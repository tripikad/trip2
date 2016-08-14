<?php

namespace App\Http\Controllers;

use Response;

class V2HelpersController extends Controller
{
    public function alert()
    {
        return Response::json([
            'info' => session('info'),
        ]);
    }
}
