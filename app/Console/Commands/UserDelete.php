<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UserDelete extends Command
{
    protected $signature = 'user:delete { id } ';

    protected $description = 'Deletes user and all related data.';

    public function handle()
    {
        $id = $this->argument('id');

        /** @var User $user */
        $user = User::findorfail($id);

        $this->info('this user has posted '.$user->contents->count().' times');
        $this->info('this user has commented on '.$user->comments->count().' posts');

        if ($this->confirm("Do you wish to delete user: $user->name? [yes|no]")) {
            $user->follows->each(function ($follow) {
                $follow->delete();
            });

            $user->comments->each(function ($comment) {
                $comment->flags->each(function ($flag) {
                    $flag->delete();
                });
            });

            //remove user contents
            $user->contents->each(function ($post) {

                //get destinations->id as array and then remove relationship

                $destinations = $post->destinations()->select('destinations.id')->pluck('id')->toArray();

                $post->destinations()->detach($destinations);

                //get topics->id as array and then remove relationship

                $topics = $post->topics()->select('topics.id')->pluck('id')->toArray();

                $post->topics()->detach($topics);

                //get carriers->id as array and then remove relationship

                $carriers = $post->carriers()->select('carriers.id')->pluck('id')->toArray();

                $post->carriers()->detach($carriers);

                //remove content comments

                $post->comments->each(function ($comment) {
                    $comment->flags->each(function ($flag) {
                        $flag->delete();
                    });
                });

                //remove content flags

                $post->flags->each(function ($flag) {
                    $flag->delete();
                });

                //remove content followers

                $post->followers->each(function ($follower) {
                    $follower->delete();
                });
            });

            //remove messages
            $sent = $user->hasMany('App\Message', 'user_id_from')->get();
            $received = $user->hasMany('App\Message', 'user_id_to')->get();
            $messages = $sent->merge($received);

            //delete messages
            $messages->each(function ($message) {
                $message->delete();
            });

            //remove images
            $user->images->each(function ($image) {
                if ($image->preset('original')) {
                    File::delete($image->preset('small'));
                    File::delete($image->preset('small_square'));
                    File::delete($image->preset('xsmall_square'));
                    File::delete($image->preset('original'));
                    File::delete($image->preset('medium'));
                    File::delete($image->preset('large'));
                }

                $image->delete();
            });

            $user->delete();

            $this->line("user: $user->name and all user data has been deleted");
        }
    }
}
