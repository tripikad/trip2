<?php

namespace App\Http\Controllers;

use Auth;
use App;

class FlagController extends Controller
{
    public function toggle($flaggable_type, $flaggable_id, $flag_type)
    {
        $flag_types = [
            'havebeen',
            'wantstogo',
            'bad',
            'good',
        ];

        $typeMap = [
            'content' => 'App\Content',
            'comment' => 'App\Comment',
            'destination' => 'App\Destination',
        ];

        if(in_array($flag_type, $flag_types) && array_key_exists($flaggable_type, $typeMap)) {
            if($typeMap[$flaggable_type]::find($flaggable_id)) {
                $fields = [
                    'flaggable_type' => $typeMap[$flaggable_type],
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

        return back();
    }
}
