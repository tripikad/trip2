<?php

namespace App\Http\Controllers;

use Redirect;
use URL;

class V2SocialController extends Controller
{
    public function share($social)
    {
        if (array_key_exists($social, config('utils.share'))) {
            return Redirect::away(config("utils.share.$social").URL::previous());
        }

        return back();
    }
}
