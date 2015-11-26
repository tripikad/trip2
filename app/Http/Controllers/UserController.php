<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Image;
use App\Destination;
use Hash;

class UserController extends Controller
{
    public function show($id)
    {
        $types = ['forum', 'travelmate', 'photo', 'blog', 'news', 'flights'];
        $types2 = ['forum', 'travelmate', 'photo', 'blog', 'news', 'flights'];

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

        $now = Carbon::now();

        $latest_announcement = $user
            ->contents()
            ->whereStatus(1)
            ->whereIn('type', ['travelmate'])
            ->where('start_at', '>=', $now)
            ->latest('created_at')
            ->take(1)
            ->first();

        $photos = $user
            ->contents()
            ->whereStatus(1)
            ->where('type', 'photo')
            ->latest('created_at')
            ->take(8)
            ->get();

        $count_photos = $user
            ->contents()
            ->whereStatus(1)
            ->where('type', 'photo')
            ->count();

        $activity_content = $user
            ->contents()
            ->whereStatus(1)
            ->whereIn('type', $types2)
            ->latest('created_at')
            ->take(4)
            ->get()
            ->transform(function ($item) {
                $item['activity_type'] = 'content';

                return $item;
            });

        $activity_comment = $user
            ->comments()
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest('created_at')
            ->take(4)
            ->get()
            ->transform(function ($item) {
                $item['activity_type'] = 'comment';

                return $item;
            });

        $activities = $activity_content
            ->merge($activity_comment)
            ->sortByDesc('created_at')
            ->take(4);

        $blog_posts = $user
            ->contents()
            ->whereStatus(1)
            ->where('type', 'blog')
            ->latest('created_at')
            ->take(1)
            ->get();

        $flights = $user
            ->contents()
            ->whereStatus(1)
            ->where('type', 'flight')
            ->latest('created_at')
            ->take(3)
            ->get();

        $destinations_count = Destination::count();

        if ($user->destinationHaveBeen()->count() > 0 && $destinations_count > 0) {
            $destinations_percent = round(($user->destinationHaveBeen()->count() * 100) / $destinations_count, 2);
        } else {
            $destinations_percent = 0;
        }

        $user_status = [];

        return response()->view('pages.user.show', [
            'user' => $user,
            'user_status' => $user_status,
            'content_count' => $content_count,
            'comment_count' => $comment_count,
            'latest_announcement' => $latest_announcement,
            'photos' => $photos,
            'count_photos' => $count_photos,
            'activities' => $activities,
            'blog_posts' => $blog_posts,
            'flights' => $flights,
            'destinations_count' => $destinations_count,
            'destinations_percent' => $destinations_percent,
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
                'image' => 'required|image',
            ]);

            $filename = 'picture-'
                .$user->id
                .'.'
                .$request->file('image')->getClientOriginalExtension();

            $filename = Image::storeImageFile($request->file('image'), $filename);

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
            'password' => $user->password,
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
