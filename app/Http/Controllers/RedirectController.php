<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;
use App\Carrier;

class RedirectController extends Controller
{
    public function redirectNode($node_id)
    {
        if ($content = Content::find($node_id)) {
            return redirect()->route(
                'content.show', [
                    $content->type,
                    $content,
                ], 301);
        }

        abort(404);
    }

    public function redirectContent($path)
    {
        $alias = \DB::table('aliases')
            ->wherePath('content/'.$path)
            ->first();

        if ($alias) {
            $content = Content::find($alias->aliasable_id);

            return redirect()
                ->route('content.show', [
                    $content->type,
                    $content,
                ], 301);
        }

        abort(404);
    }

    public function redirectAlias($part1, $part2 = '')
    {
        $pathMap = [

            'content/mis-on-veahind.html' => 'content/static/97203',
            'kasutustingimused' => 'content/static/25151',
            'reklaam' => 'content/static/22125',
            'misontripee' => 'content/static/1534',
            'kontakt' => 'content/static/972',

            'blog' => 'content/blog',
            'paevikud' => 'content/blog',
            'sein/paevikud' => 'content/blog',

            'eluvalismaal' => 'content/expat',

            'pildid' => 'content/photo',

            'uudised' => 'content/news',
            'sein/uudised' => 'content/news',

            'reisikaaslased' => 'content/travelmate',
            'sein/reisikaaslased' => 'content/travelmate',

            'ostmuuk' => 'content/buysell',

            'soodsad_lennupiletid' => 'content/flight',
            'lendude_sooduspakkumised' => 'content/flight',

            'foorum' => 'content/forum',
            'sein/foorum' => 'content/forum',

            'reisipakkumised' => '/',
            'sein/reisipakkumised' => '/',
            'sein/turg' => '/',


            'sein' => '/',

        ];

        $path = $part2 ? $part1."/".$part2 : $part1;

        if (isset($pathMap[$path])) {

            return redirect($pathMap[$path], 301);
        
        }

        abort(404);
        
    }


    public function redirectTaxonomy($tid)
    {
        $alias = \DB::table('aliases')
            ->wherePath('taxonomy/term/'.$tid)
            ->first();

        $tid = $alias ? $alias->aliasable_id : $tid;

        if ($destination = Destination::find($tid)) {
            return redirect()->route(
                'destination.show', [
                    $destination,
                ], 301);
        }

        if ($topic = Topic::find($tid)) {
            return redirect()->route(
                'content.index', [
                    'forum',
                    'topic' => $topic,
                ], 301);
        }

        if ($carrier = Carrier::find($tid)) {
            return redirect()->route(
                'content.index', [
                    'flight',
                    'carrier' => $carrier,
                ], 301);
        }

        return redirect()->route(
            'content.index', [
                'forum'
            ], 301);
    }

    public function redirectTaxonomyBlurb($blurb = '', $tid) {
    
        return $this->redirectTaxonomy($tid);
    
    }

    public function redirectDestination($title)
    {
        $alias = \DB::table('aliases')
            ->wherePath('sihtkoht/'.$title)
            ->first();

        if ($alias) {
            $destination = Destination::find($alias->aliasable_id);

            return redirect()->route(
                'destination.show', [
                    $destination,
                ], 301);
        }

        abort(404);
    }

    public function redirectDestinationBlurb($blurb = '', $title) {
    
        return $this->redirectDestination($title);
    
    }

    public function redirectDestinationBlurb2($blurb = '', $blurb2 = '', $title) {
    
        return $this->redirectDestination($title);
    
    }

    public function redirectCategory($part1, $part2, $part3 = null, $part4 = null)
    {
        $path = collect(['category', $part1, $part2, $part3, $part4])
            ->reject(function ($name) {
                return empty($name);
            })
            ->implode('/');

        $alias = \DB::table('aliases')
            ->wherePath($path)
            ->first();

        if ($alias) {
            if ($destination = Destination::find($alias->aliasable_id)) {
                return redirect()->route(
                    'destination.show', [
                        $destination,
                    ], 301);
            }

            if ($topic = Topic::find($alias->aliasable_id)) {
                return redirect()->route(
                    'content.index', [
                        'forum',
                        'topic' => $topic,
                    ], 301);
            }

            return redirect()->route(
                'content.index', [
                    'forum',
                ], 301);

        }

        abort(404);
    }

    public function redirectCategoryBlurb($blurb = '', $part1, $part2, $part3 = null, $part4 = null) {
    
        return $this->redirectCategory($part1, $part2, $part3, $part4);
    
    }

    public function redirectUser($id)
    {

       return redirect()->route('user.show', [$id], 301);

    }
    
}
