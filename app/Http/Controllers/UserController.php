<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Imageconv;

use \App\User;

class UserController extends Controller
{

    public function show($id)
    {

        $user = User::findorFail($id);
  
        $number_forum = $user->contents()->whereType('forum')->count();
        $number_comment = $user->comments()->count();
      
        $from = Carbon::now()->subMonths(3)->startOfMonth();
        $to = Carbon::now();

        $content = User::findOrFail($id)
            ->contents()
            ->whereStatus(1)
            ->whereIn('type', ['forum', 'travelmate', 'photo', 'blog'])
            ->whereBetween('created_at', [$from, $to])
            ->latest('created_at')
            ->get()
            ->transform(function ($item) {
                $item['activity_type'] = 'content';
                return $item;
            });

        $comments = User::findOrFail($id)
            ->comments()
            ->whereStatus(1)
            ->whereBetween('created_at', [$from, $to])
            ->latest('created_at')
            ->get()
            ->transform(function ($item) {
                $item['activity_type'] = 'comment';
                return $item;
            });
    
        $items = $content->merge($comments)->sortByDesc('created_at');

        return View::make('pages.user.show')
            ->with('user', $user)
            ->with('number_forum', $number_forum)
            ->with('number_comment', $number_comment)
            ->with('items', $items)
            ->render();    
    }

    public function edit($id)
    {

        $user = User::findorFail($id);

        return View::make("pages.user.edit")
            ->with('user', $user)
            ->with('title', trans('user.edit.title'))
            ->with('url', route('user.update', [$user]))
            ->with('method', 'put')
            ->with('submit', trans('user.edit.submit'))
            ->render();

    }

    public function update(Request $request, $id)
    {
        $user = User::findorFail($id);

        if ($request->get('image_submit')) {
        
            $this->validate($request, [
                'file' => 'required|image',
            ]); 

            $image = 'picture-'
                . $user->id
                . '.'
                . $request->file('file')->getClientOriginalExtension();

            $imagepath = public_path() . '/images/user/';
            $smallimagepath = public_path() . '/images/user/small/';
            
            $request->file('file')->move($imagepath, $image);

            Imageconv::make($imagepath . $image)
                ->fit(200)
                ->save($smallimagepath . $image);
            
            $user->update(['image' => $image]);

            return redirect()
                ->route('user.edit', [$user])
                ->withInput()
                ->with('status', trans('user.update.image.status'));
        
        }

        $this->validate($request, [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
        ]); 

        $user->update($request->all());

        return redirect()
            ->route('user.show', [$user])
            ->with('status', trans('user.update.status'));
    }

    public function showMessages($id)
    {
        $user = User::findorFail($id);
     
        return View::make('pages.user.message.index')
            ->with('user', $user)
            ->render();
    }

    public function showMessagesWith($id, $user_id_with)
    {
        $user = User::findorFail($id);
        $user_with = User::findorFail($user_id_with);
     
        return View::make('pages.user.message.with')
            ->with('user', $user)
            ->with('user_with', $user_with)
            ->with('messages', $user->messagesWith($user_id_with))
            ->render();
    }

    public function showFollows($id)
    {
        $user = User::with('follows')
            ->findorFail($id);
     
        return View::make('pages.user.follow.index')
            ->with('user', $user)
            ->render();
    }

}
