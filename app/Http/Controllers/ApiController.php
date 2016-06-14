<?php

namespace App\Http\Controllers;

use App\Destination;

class ApiController extends Controller
{
    
    public function destinations()
    {

        return Destination::select('id', 'parent_id', 'name')->get();
    
    }

}
