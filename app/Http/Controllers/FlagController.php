<?php

namespace App\Http\Controllers;

use Auth;
use App;
use Request;
use Log;

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

                    $flag = Auth::user()->flags()->where($fields);

                    if (count($flag->get())) {
                        $flag->delete();
                    } else {
                        Auth::user()->flags()->create($fields);

                        Log::info('Content has been flagged', [
                            'user' =>  Auth::user()->name,
                            'data' =>  [
                                'type' => $flaggable_type,
                                'id' => $flaggable_id,
                                'flagtype' => $flag_type
                            ]
                        ]);

                    }
                }
            }
        }

        if (Request::ajax()) {
            if (($flaggable_type == 'content' || $flaggable_type == 'comment')
                && in_array($flag_type, $flags[$flaggable_type]['flag_types'])) {
                return $flags[$flaggable_type]['controller']::find($flaggable_id)
                    ->flags()
                    ->where([
                        'flaggable_type' => $flags[$flaggable_type]['controller'],
                        'flag_type' => $flag_type,
                    ])
                    ->count();
            } else {
                return back();
            }
        } else {
            return back();
        }
    }
}
