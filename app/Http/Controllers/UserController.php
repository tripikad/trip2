<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Imageconv;

use App\User;
use App\Message;

class UserController extends Controller
{

    public function show($id)
    {

        $types = ['forum', 'travelmate', 'photo', 'blog', 'news', 'flights'];

        $user = User::with('flags', 'flags.flaggable')->findorFail($id);
  
        $content_count = $user
            ->contents()
            ->whereStatus(1)
            ->whereIn('type', $types)
            ->count();

        $comment_count = $user
            ->comments()
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->count();
      
        $from = Carbon::now()->subMonths(6)->startOfMonth();
        $to = Carbon::now();

        $content = $user
            ->contents()
            ->whereStatus(1)
            ->whereIn('type', $types)
            ->whereBetween('created_at', [$from, $to])
            ->latest('created_at')
            ->get()
            ->transform(function ($item) {
                $item['activity_type'] = 'content';
                return $item;
            });

        $comments = $user
            ->comments()
            ->with('content')
            ->whereStatus(1)
            ->whereBetween('created_at', [$from, $to])
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest('created_at')
            ->get()
            ->transform(function ($item) {
                $item['activity_type'] = 'comment';
                return $item;
            });
    
        $items = $content
            ->merge($comments)
            ->sortByDesc('created_at');

        return response()->view('pages.user.show', [
            'user' => $user,
            'items' => $items,
            'content_count' => $content_count,
            'comment_count' => $comment_count
        ])->header('Cache-Control', 'public, s-maxage=' . config('site.cache.user'));
    
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
            'contact_facebook' => 'url',
            'contact_twitter' => 'url',
            'contact_instagram' => 'url',
            'contact_homepage' => 'url'
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
     
        $messageIds = $user->messagesWith($user_id_with)->keyBy('id')->keys()->toArray();

        Message::whereIn('id', $messageIds)->update(['read' => 1]);

        return View::make('pages.user.message.with')
            ->with('user', $user)
            ->with('user_with', $user_with)
            ->with('messages', $user->messagesWith($user_id_with)->all())
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
