<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Log;

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

    public function error() {
        $error = Request::get('error');
        if ($error) {
            $error['error'] = preg_replace('/[\s+|\n+]/', ' ', $error['error']);
            if ($error['type'] == 'warning') {
                Log::warning($error);
            }
            if ($error['type'] == 'error') {
                Log::error($error);
            }
        }
    }
}
