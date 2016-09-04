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

        $userimages = $user
            ->contents()
            ->whereStatus(1)
            ->where('type', 'photo')
            ->latest('created_at')
            ->take(6)
            ->get()
                ->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'small' => $image->imagePreset('small_square'),
                        'large' => $image->imagePreset('large'),
                        'meta' => component('Meta')->with('items', collect()
                            ->push(component('MetaLink')
                                ->with('title', $image->title)
                            )
                            ->push(component('MetaLink')
                                ->with('title', $image->created_at)
                            )
                        )->render(),
                    ];
                });

        return view('v2.layouts.2col')

            ->with('header', region('UserHeader', $user))

            ->with('content', collect()
                ->push(component('Gallery')->with('images', $userimages))
                ->merge($comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect(['UserBlog'])))
            )

            ->with('footer', region('Footer'));
    }
}
