<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function store(Request $request, $user_id_from, $user_id_to)
    {

        $this->validate($request, ['body' => 'required']);

        $fields = ['user_id_from' => $user_id_from, 'user_id_to' => $user_id_to];

        $message = \App\Message::create(array_merge($request->all(), $fields));
        
        return redirect()->route('user.show.messages.with', [
            $user_id_from, $user_id_to, '#message-' . $message->id
        ]);
    
    }

}
