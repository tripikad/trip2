<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use DB;
use Carbon\Carbon;

class MailActive extends Command
{
    
    protected $signature = 'mail:active';

    public function handle()
    {
   

        $top_commenters_ids = App\User::leftJoin('comments', 'comments.user_id', '=', 'users.id')
            ->select('users.id', DB::Raw('count(*) as commentsCount'))
            ->whereDate('comments.created_at', '>=', Carbon::today()->subYears(3)->toDateString())
            ->where('users.role', '=', 'regular')
            ->groupBy('users.id')
            ->orderBy('commentsCount', 'desc')
            ->take(20)
            ->lists('users.id');

        $top_contenters_ids = App\User::leftJoin('contents', 'contents.user_id', '=', 'users.id')
            ->select('users.id', DB::Raw('count(*) as contentsCount'))
            ->whereDate('contents.created_at', '>=', Carbon::today()->subYears(3)->toDateString())
            ->where('users.role', '=', 'regular')
            ->groupBy('users.id')
            ->orderBy('contentsCount', 'desc')
            ->take(20)
            ->lists('users.id');
        
        $top_ids = $top_commenters_ids->merge($top_contenters_ids)->unique();
        
        App\User::whereIn('id', $top_ids)->each(function($user) {
            dump($user->email);
        });

    }
}
