<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Carbon\Carbon;

use App\User;

class ActivityController extends Controller
{

 
    public function index($id)
    {

        $user = User::findOrFail($id);
    
        $from = Carbon::now()->subMonths(12)->startOfMonth();
        $to = Carbon::now();

        $content = User::findOrFail($id)
            ->contents()
            ->whereStatus(1)
            ->whereIn('type', ['forum', 'travelmate', 'photo', 'blog'])
            ->whereBetween('created_at', [$from, $to])
            ->latest('created_at')
            ->get();

        $comments = User::findOrFail($id)
            ->comments()
            ->whereStatus(1)
            ->whereBetween('created_at', [$from, $to])
            ->latest('created_at')
            ->get();
    
        return View::make('pages.activity.index')
            ->with('items', $content->merge($comments)->sortByDesc('created_at'))
            ->with('user', $user)
            ->render();

    }

}
