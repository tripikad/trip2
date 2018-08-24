<?php

namespace App\Http\Controllers;

use App\Content;
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

    public function flights()
    {
        $flights = Content::getLatestItems('flight', 24)
            ->map(function ($f) {
                return collect()
                    ->put('title', $f->title)
                    ->put('image', $f->getHeadImage())
                    ->put('body', format_body($f->body))
                ;
            });
        
        return response()
            ->json($flights)
            ->withHeaders([
                'Access-Control-Allow-Origin' => '*'
            ]);
            
    }
}
