<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Image;
use Hash;


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
            'comment_count' => $comment_count,
        ])->header('Cache-Control', 'public, s-maxage='.config('site.cache.user'));
    }

    public function edit($id)
    {
        $user = User::findorFail($id);

        return View::make('pages.user.edit')
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

            $filename = 'picture-'
                .$user->id
                .'.'
                .$request->file('file')->getClientOriginalExtension();

            $filename = Image::storeImageFile($request->file('file'), $filename);

            $user->images()->delete();
            $user->images()->create(['filename' => $filename]);

            return redirect()
                ->route('user.edit', [$user])
                ->withInput()
                ->with('status', trans('user.update.image.status'));
        }

        $this->validate($request, [
            'name' => 'required|unique:users,name,'.$user->id,
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'contact_facebook' => 'url',
            'contact_twitter' => 'url',
            'contact_instagram' => 'url',
            'contact_homepage' => 'url',
        ]);

        $fields = [
            'password' => $user->password
        ];

        if (trim($request->get('password'))) {
            $fields['password'] = Hash::make($request->get('password'));
        }

        $user->update(array_merge($request->all(), $fields));

        return redirect()
            ->route('user.show', [$user])
            ->with('info', trans('user.update.info'));
    }
}
