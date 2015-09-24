<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;

use App\User;

class FollowController extends Controller
{

    public function index($user_id)
    {

        $user = User::with('follows')
            ->findorFail($user_id);
     
        return View::make('pages.follow.index')
            ->with('user', $user)
            ->render();

    }

    public function followContent($type, $id, $status)
    {

        $content = \App\Content::findorFail($id);

        if ($status == 1) {

            auth()->user()->follows()->create([
                'followable_id' => $id,
                'followable_type' => 'App\Content'
            ]);

            return back()
                ->with('info', trans("content.action.follow.$status.info", [
                    'title' => $content->title
                ]));
        
        }

        if ($status == 0) {

            auth()->user()->follows()->where([
                'followable_id' => $id,
                'followable_type' => 'App\Content'
            ])->delete();

            return back()
                ->with('info', trans("content.action.follow.$status.info", [
                    'title' => $content->title
                ]));
        
        }
        
        return back();

    }

}