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

        if ($this->confirm("Do you wish to delete user: $user->name? [yes|no]"))
        {

                $user->comments->each(function ($comment) {

                    $comment->delete();

                });

                $user->contents->each(function ($post) {

                    $post->comments->each(function ($comment){

                        $comment->delete();

                    });

                    $post->delete();
                });

                $user->images->each(function ($image) {

                    $image->delete();

                });

            $user->delete();

            $this->line("user: $user->name and all user posts have been deleted");
    }
}
