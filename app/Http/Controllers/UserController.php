<?php

namespace App\Http\Controllers;

use Hash;
use View;
use App\Flag;
use App\User;
use App\Image;
use Carbon\Carbon;
use App\Destination;
use Illuminate\Http\Request;

class UserController extends Controller
{   /*
    public function show($id)
    {
        $types = ['forum', 'travelmate', 'photo', 'blog', 'news', 'flights'];

        $user = User::with(['flags.flaggable'])->where('name', '!=', 'Tripi külastaja')->findorFail($id);

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
            ->whereIn('type', ['forum', 'travelmate', 'blog', 'news', 'flights'])
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
            ->get()
            ->unique('content_id')
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

            if (! $request->ajax()) {
                return redirect()
                    ->route('user.edit', [$user])
                    ->withInput()
                    ->with('status', trans('user.update.image.status'));
            } else {
                exit();
            }
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
//          'birthyear' => 'required|digits:4',
//          'gender' => 'required',
//          'real_name' => 'required',
        ]);

        $fields = [
            'password' => $user->password,
        ];

        if (trim($request->get('password'))) {
            $fields['password'] = Hash::make($request->get('password'));
        }

        $allowedFields = ['name', 'email', 'contact_facebook', 'contact_twitter', 'contact_instagram', 'contact_homepage', 'real_name', 'gender', 'birthyear', 'description', 'profile_color'];

        if ($request->real_name_show == '') {
            $fields['real_name_show'] = 1;
        } else {
            $fields['real_name_show'] = 0;
        }

        if ($request->notify_message) {
            $fields['notify_message'] = 1;
        } else {
            $fields['notify_message'] = 0;
        }

        if ($request->notify_follow) {
            $fields['notify_follow'] = 1;
        } else {
            $fields['notify_follow'] = 0;
        }

        foreach ($request->all() as $field_name => $field_value) {
            if (in_array($field_name, $allowedFields)) {
                $fields[$field_name] = $field_value;
            }
        }

        $user->update($fields);

        if (! $request->ajax()) {
            return redirect()
                ->route('user.show', [$user])
                ->with('info', trans('user.update.info'));
        }
    }

    public function destinationsIndex($id)
    {
        $user = User::with(['flags.flaggable'])->findorFail($id);

        $user_have_been = $user->destinationHaveBeen()->pluck('flaggable_id')->toArray();
        $have_been_destinations = Destination::getNames();

        if (count($user_have_been)) {
            $have_been_destinations->forget($user_have_been);
        }

        $have_been_destination = [];

        $user_want_to_go = $user->destinationWantsToGo()->pluck('flaggable_id')->toArray();
        $want_to_go_destinations = Destination::getNames()->forget($user_want_to_go);

        if (count($user_want_to_go)) {
            $want_to_go_destinations->forget($user_want_to_go);
        }

        $want_to_go_destination = [];

        return response()->view('pages.user.destinations', [
            'user' => $user,
            'have_been_destinations' => $have_been_destinations,
            'have_been_destination' => $have_been_destination,
            'want_to_go_destinations' => $want_to_go_destinations,
            'want_to_go_destination' => $want_to_go_destination,
        ])->header('Cache-Control', 'public, s-maxage='.config('site.cache.user'));
    }

    public function destinationStore(Request $request, $id)
    {
        $user = User::findorFail($id);

        $this->validate($request, [
            'have_been' => 'required_without:want_to_go',
            'want_to_go' => 'required_without:have_been',
        ]);

        $user_have_been = $user->destinationHaveBeen();
        $user_wants_to_go = $user->destinationWantsToGo();

        $fields = [];
        if ($request->has('have_been')) {
            foreach ($request->have_been as $have_been) {
                if (count($user_have_been->where('flaggable_id', (int) $have_been)) == 0) {
                    $fields[] = new Flag([
                        'flaggable_type' => 'App\Destination',
                        'flaggable_id' => $have_been,
                        'flag_type' => 'havebeen',
                    ]);
                }
            }
        }

        if ($request->has('want_to_go')) {
            foreach ($request->want_to_go as $want_to_go) {
                if (count($user_wants_to_go->where('flaggable_id', (int) $want_to_go)) == 0) {
                    $fields[] = new Flag([
                        'flaggable_type' => 'App\Destination',
                        'flaggable_id' => $want_to_go,
                        'flag_type' => 'wantstogo',
                    ]);
                }
            }
        }

        $user->flags()
            ->saveMany($fields);

        return redirect()
            ->route('user.destinations', [$user])
            ->with('info', trans('user.destinations.update.info'));
    }
    */
}
