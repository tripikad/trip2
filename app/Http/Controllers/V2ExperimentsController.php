<?php

namespace App\Http\Controllers;

use DB;
use Charts;
use App\Flag;
use App\User;
use App\Comment;
use App\Content;
use Carbon\Carbon;

class V2ExperimentsController extends Controller
{
    public function chart()
    {
        $users1 = User::select(
            DB::raw("DATE_FORMAT(created_at, '%M') date"),
            DB::raw('count(users.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(users.created_at)'))
        ->whereBetween(
            'created_at', [
                \Carbon\Carbon::now()->subYear(3)->startOfYear(),
                \Carbon\Carbon::now()->subYear(3)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $users2 = User::select(
            DB::raw("DATE_FORMAT(created_at, '%M') date"),
            DB::raw('count(users.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(users.created_at)'))
        ->whereBetween(
            'created_at', [
                \Carbon\Carbon::now()->subYear(2)->startOfYear(),
                \Carbon\Carbon::now()->subYear(2)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $users3 = User::select(
            DB::raw("DATE_FORMAT(created_at, '%M') date"),
            DB::raw('count(users.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(users.created_at)'))
        ->whereBetween(
            'created_at', [
                \Carbon\Carbon::now()->subYear(1)->startOfYear(),
                \Carbon\Carbon::now()->subYear(1)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $contents1 = Content::select(
            'contents.created_at',
            DB::raw('count(contents.id) as aggregate')
        )
        ->whereIn('contents.type', ['forum', 'buysell', 'expat', 'travelmate'])
        ->groupBy(DB::raw('MONTH(contents.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(3)->startOfYear(),
                Carbon::now()->subYear(3)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $contents2 = Content::select(
            'contents.created_at',
            DB::raw('count(contents.id) as aggregate')
        )
        ->whereIn('contents.type', ['forum', 'buysell', 'expat', 'travelmate'])
        ->groupBy(DB::raw('MONTH(contents.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(2)->startOfYear(),
                Carbon::now()->subYear(2)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $contents3 = Content::select(
            'contents.created_at',
            DB::raw('count(contents.id) as aggregate')
        )
        ->whereIn('contents.type', ['forum', 'buysell', 'expat', 'travelmate'])
        ->groupBy(DB::raw('MONTH(contents.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(1)->startOfYear(),
                Carbon::now()->subYear(1)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $comments1 = Comment::select(
            'comments.created_at',
            DB::raw('count(comments.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(comments.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(3)->startOfYear(),
                Carbon::now()->subYear(3)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $comments2 = Comment::select(
            'comments.created_at',
            DB::raw('count(comments.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(comments.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(2)->startOfYear(),
                Carbon::now()->subYear(2)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $comments3 = Comment::select(
            'comments.created_at',
            DB::raw('count(comments.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(comments.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(1)->startOfYear(),
                Carbon::now()->subYear(1)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $flags1 = Flag::select(
            'flags.created_at',
            DB::raw('count(flags.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(flags.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(3)->startOfYear(),
                Carbon::now()->subYear(3)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $flags2 = Flag::select(
            'flags.created_at',
            DB::raw('count(flags.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(flags.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(2)->startOfYear(),
                Carbon::now()->subYear(2)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $flags3 = Flag::select(
            'flags.created_at',
            DB::raw('count(flags.id) as aggregate')
        )
        ->groupBy(DB::raw('MONTH(flags.created_at)'))
        ->whereBetween(
            'created_at', [
                Carbon::create()->subYear(1)->startOfYear(),
                Carbon::now()->subYear(1)->endOfYear(),
            ]
        )
        ->orderBy('created_at')
        ->get();

        $userChart = Charts::multi('line', 'google')
              ->title('New users per month')
              ->elementLabel('Registrered users per month')
              ->dimensions(1800, 600)
              ->colors(['#b5c0c9', '#6794bc', '#08f'])
              ->labels($users1->pluck('date'))
              ->dataset('2014', $users1->pluck('aggregate'))
              ->dataset('2015', $users2->pluck('aggregate'))
              ->dataset('2016', $users3->pluck('aggregate'));

        $contentChart = Charts::multi('line', 'google')
              ->title('New content per month')
              ->elementLabel('User created content per month')
              ->dimensions(800, 200)
              ->colors(['#c5b8af', '#d99063', '#c24a00'])
              ->labels($contents1->pluck('date'))
              ->dataset('2014', $contents1->pluck('aggregate'))
              ->dataset('2015', $contents2->pluck('aggregate'))
              ->dataset('2016', $contents3->pluck('aggregate'));

        $commentsChart = Charts::multi('line', 'google')
              ->title('New comments per month')
              ->elementLabel('Comments per month')
              ->colors(['#aea1bf', '#8357bc', '#6600eb'])
              ->dimensions(800, 600)
              ->labels($comments1->pluck('date'))
              ->dataset('2014', $comments1->pluck('aggregate'))
              ->dataset('2015', $comments2->pluck('aggregate'))
              ->dataset('2016', $comments3->pluck('aggregate'));

        $flagsChart = Charts::multi('line', 'google')
              ->title('New flags per month')
              ->elementLabel('Flags per month')
              ->colors(['#ccc', '#888', '#333'])
              ->dimensions(800, 600)
              ->labels($flags1->pluck('date'))
              ->dataset('2014', $flags1->pluck('aggregate'))
              ->dataset('2015', $flags2->pluck('aggregate'))
              ->dataset('2016', $flags3->pluck('aggregate'));

        return layout('1col')
            ->with('content', collect()
                ->push($userChart->render())
                ->push($contentChart->render())
                ->push($commentsChart->render())
                ->push($flagsChart->render())
            )
            ->render();
    }

    public function test()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('Logi sisse'))
            ))

            ->with('content', collect(range(0, 20))->map(function ($i) {
                return '<br>';
            }))

            ->with('bottom', collect(range(0, 3))->map(function ($i) {
                return '<br>';
            }))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()

                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormRadio')
                        ->with('name', 'type')
                        ->with('value', 'travelmate')
                        ->with('options', collect()
                            ->push(['id' => 'forum', 'name' => 'Foorum'])
                            ->push(['id' => 'travelmate', 'name' => 'Travelmate'])
                        )
                    )
                ))

                ->push(component('Title')
                    ->with('title', 'Blog')
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: index')
                    ->with('route', route('experiments.blog.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: show')
                    ->with('route', route('experiments.blog.show'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: edit')
                    ->with('route', route('experiments.blog.edit'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: profile')
                    ->with('route', route('experiments.blog.profile'))
                )

                ->push(component('Title')
                    ->with('title', 'Vealehed')
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 401')
                    ->with('route', route('error.show', [401]))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 404')
                    ->with('route', route('error.show', [404]))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 500')
                    ->with('route', route('error.show', [500]))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 503')
                    ->with('route', route('error.show', [503]))
                )

            )

            ->render();
    }
}
