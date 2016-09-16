<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;

class V2UserController extends Controller
{
    public function show($id)
    {
        $types = ['forum', 'travelmate', 'buysell'];

        $user = User::findOrFail($id);

        $comments = $user->comments()
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest()
            ->take(10)
            ->get();

        $blogs = $user
            ->contents()
            ->whereStatus(1)
            ->whereType('blog')
            ->take(3)
            ->get();

        $images = $user
            ->contents()
            ->whereStatus(1)
            ->whereType('photo')
            ->latest('created_at')
            ->take(6)
            ->get();

        return view('v2.layouts.1col')

            ->with('header', region('UserHeader', $user))

            ->with('content', collect()
                ->push(region('Gallery', $images))
                ->push(component('Grid3')
                    ->with('items', $blogs->map(function ($blog) {
                        return region('BlogCard', $blog);
                    })
                ))
                ->merge($comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
            )

            ->with('footer', region('Footer'));
    }
}
