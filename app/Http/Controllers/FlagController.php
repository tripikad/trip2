<?php

namespace App\Http\Controllers;

use Auth;
use App;

class FlagController extends Controller
{
    public function toggle($flaggable_type, $flaggable_id, $flag_type)
    {
        $flags = [
            'content' => [
                'flag_types' => ['bad', 'good'],
                'controller' => 'App\Content',
            ],
            'comment' => [
                'flag_types' => ['bad', 'good'],
                'controller' => 'App\Comment',
            ],
            'destination' => [
                'flag_types' => ['havebeen', 'wantstogo'],
                'controller' => 'App\Destination',
            ],
        ];

        if (isset($flags[$flaggable_type]) && count($flags[$flaggable_type])) {
            $flag_types = $flags[$flaggable_type]['flag_types'];
            $typeMap = $flags[$flaggable_type]['controller'];

            if (in_array($flag_type, $flag_types)) {
                if ($typeMap::find($flaggable_id)) {
                    $fields = [
                        'flaggable_type' => $typeMap,
                        'flaggable_id' => $flaggable_id,
                        'flag_type' => $flag_type,
                    ];

                    if ($flag = Auth::user()->flags()->where($fields)->first()) {
                        $flag->delete();
                    } else {
                        Auth::user()->flags()->create($fields);
                    }
                }
            }
        }

        return back();
    }
}
