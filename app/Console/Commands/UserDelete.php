<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class UserDelete extends Command
{
    protected $signature = 'user:delete { id } ';

    protected $description = 'Deletes user and all related posts to this user.';

    public function handle()
    {
        $id = $this->argument('id');

        $user = User::findorfail($id);

        if ($this->confirm("Do you wish to delete user: $user->name? [yes|no]")) {
            $user->flags->each(function ($flag) {
                $flag->delete();
            });

            $user->comments->each(function ($comment) {
                $comment->delete();
            });

            //remove user contents
            $user->contents->each(function ($post) {

                //get destinations->id as array and then remove relationship

                $destinations = $post->destinations()->select('destinations.id')->lists('id')->toArray();

                $post->destinations()->detach($destinations);

                //get topics->id as array and then remove relationship

                $topics = $post->topics()->select('topics.id')->lists('id')->toArray();

                $post->topics()->detach($topics);

                //get carriers->id as array and then remove relationship

                $carriers = $post->carriers()->select('carriers.id')->lists('id')->toArray();

                $post->carriers()->detach($carriers);

                //remove content comments

                $post->comments->each(function ($comment) {
                    $comment->delete();
                });

                $post->delete();
            });

            $user->images->each(function ($image) {
                if ($image->imagePresets('original')) {
                    File::delete($image->imagePresets('small'));
                    File::delete($image->imagePresets('small_square'));
                    File::delete($image->imagePresets('xsmall_square'));
                    File::delete($image->imagePresets('original'));
                    File::delete($image->imagePresets('medium'));
                    File::delete($image->imagePresets('large'));
                }

                $image->delete();
            });

            $user->delete();

            $this->line("user: $user->name and all user posts have been deleted");
        }
    }
}
