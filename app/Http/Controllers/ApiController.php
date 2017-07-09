<?php

namespace App\Http\Controllers;

use App\Destination;

class ApiController extends Controller
{
    public function destinations()
    {
        return Destination::select('id', 'parent_id', 'name')->get();
    }

    // Exposes our destinations metadata via API

    public function destinationsData()
    {
        // Convert the keyed object to array
        // for easier consuming in JS side

        $data = collect(config('destinations'))
        ->map(function ($value, $key) {
            $value['id'] = $key;

            return $value;
        })
        ->values();

        return response()->json($data);
    }
}
