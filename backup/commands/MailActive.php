<?php

namespace App\Console\Commands;

use DB;
use App;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MailActive extends Command
{
    protected $signature = 'mail:active {--ids}';

    public function handle()
    {
        $top_commenters_ids = App\User::leftJoin('comments', 'comments.user_id', '=', 'users.id')
            ->select('users.*', DB::Raw('count(comments.id) as commentsCount'))
            ->whereDate('comments.created_at', '>=', Carbon::today()->subYears(2)->toDateString())
            ->where('users.role', '=', 'regular')
            ->groupBy('users.id')
            ->orderBy('commentsCount', 'desc')
            ->take(650)
            ->pluck('users.id');

        $top_contenters_ids = App\User::leftJoin('contents', 'contents.user_id', '=', 'users.id')
            ->select('users.*', DB::Raw('count(contents.id) as contentsCount'))
            ->whereDate('contents.created_at', '>=', Carbon::today()->subYears(2)->toDateString())
            ->where('users.role', '=', 'regular')
            ->groupBy('users.id')
            ->orderBy('contentsCount', 'desc')
            ->take(90)
            ->pluck('users.id');

        $top_ids = $top_commenters_ids->merge($top_contenters_ids)->unique();

        $this->line('Username,Email');

        if ($this->option('ids')) {
            $this->line($top_ids->implode(','));
        } else {
            App\User::whereIn('id', $top_ids)->each(function ($user) {
                $this->line($user->name.','.$user->email);
            });
        }
    }
}
