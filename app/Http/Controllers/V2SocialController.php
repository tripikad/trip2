<?php

namespace App\Http\Controllers;

use Redirect;
use URL;

class V2SocialController extends Controller
{
    public function share($social)
    {
        return Redirect::away(config("utils.share.$social").URL::previous());
    }
}
