<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class FlagController extends Controller
{

    public function toggle($flaggable_type, $flaggable_id, $flag_type)
    {

        $typeMap = [
            'content' => 'App\Content',
            'comment' => 'App\Comment'
        ];
    
        $fields = [
            'flaggable_type' => $typeMap[$flaggable_type],
            'flaggable_id' => $flaggable_id,
            'flag_type' => $flag_type
        ];

        if ($flag = Auth::user()->flags()->where($fields)->first()) {

            $flag->delete();
        
        } else {

            Auth::user()->flags()->create($fields);
        }
        
        return back();
    
    }

}
