<?php

namespace App\Http\Controllers;

use App;
use Response;

class HelpersController extends Controller {

    public function alert() {

        return Response::json([
            'info' => session('info')
        ]);

    }

}
