<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

class ApiController extends Controller
{
    public function destinations()
    {
        $data = Destination::select('id', 'parent_id', 'name')->get();
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
        $flights = Content::getLatestItems('flight', 16)->map(function ($f) {
            return collect()
        ->put('title', $f->title)
        ->put('image', $f->imagePreset('original'))
        ->put('body', format_body($f->body));
        });

        return response()
      ->json($flights)
      ->withHeaders([
        'Access-Control-Allow-Origin' => '*'
      ]);
    }

    public function countrydots()
    {
        return response()->json(config('countrydots'));
    }

    public function airports()
    {
        return response()->json(config('airports'));
    }
}
