<?php

namespace App\Http\Controllers;

use Response;

class HelpersController extends Controller
{
    public function alert()
    {
        return Response::json([
            'info' => session('info'),
        ]);
    }
}
