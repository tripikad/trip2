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

        if ($this->confirm('Do you wish to continue? [yes|no]')) {
            if ($user->comments) {
                $user->comments->map(function ($comment) {
                    $comment->delete();
                });
            }

            if ($user->contents) {
                $user->contents->map(function ($post) {
                    $post->delete();
                });
            }

            if ($user->images) {
                $user->images->map(function ($image) {
                    $image->delete();
                });
            }

            $user->delete();


            $this->line("user: $user->name and all user posts have been deleted");
        }
    }
}
