<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class UserDelete extends Command
{
    protected $signature = 'user:delete { id } ';

    protected $description = 'Deletes user and all related posts to this user.';

    public function handle()
    {
        $id = $this->argument('id');

        /** @var User $user */
        $user = User::findorfail($id);

        $this->info('this user has posted:');

        $user->contents->each(function ($content) {
            $this->line($content->title);
        });

        $this->line("\n");

        $this->info('this user has commented these posts:');

        $user->comments->each(function ($comment) {
            $this->line($comment->content->title);
        });

        $this->line("\n");

        if ($this->confirm("Do you wish to delete user: $user->name? [yes|no]")) {
            $user->flags->each(function ($flag) {
                $flag->delete();
            });

            $user->comments->each(function ($comment) {
                $comment->flags->each(function ($flag) {
                    $flag->delete();
                });

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
                    $comment->flags->each(function ($flag) {
                        $flag->delete();
                    });

                    $comment->delete();
                });

                //remove content flags

                $post->flags->each(function ($flag) {
                    $flag->delete();
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

            //delete messages
            $user->messages->each(function ($message) {
                $message->delete();
            });

            $user->delete();

            $this->line("user: $user->name and all user posts have been deleted");
        }
    }
}
