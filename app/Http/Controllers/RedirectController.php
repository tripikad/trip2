<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Carrier;
use App\Content;
use App\Destination;

class RedirectController extends Controller
{
    public function redirectNode($node_id)
    {
        if ($content = Content::find($node_id)) {
            return redirect()
                ->route(
                    $content->type.'.show', [
                    $content->slug,
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
                ->route(
                    $content->type.'.show', [
                    $content->slug,
                ], 301);
        }

        abort(404);
    }

    public function redirectAlias($part1, $part2 = '')
    {
        $pathMap = [

            'content/mis-on-veahind.html' => 'mis-on-veahind',
            'kasutustingimused' => 'kasutustingimused',
            'reklaam' => 'reklaam',
            'misontripee' => 'tripist',
            'kontakt' => 'kontakt',

            'blog' => 'reisikirjad',
            'paevikud' => 'reisikirjad',
            'sein/paevikud' => 'reisikirjad',

            'eluvalismaal' => 'foorum/elu-valimaal',

            'pildid' => 'reisipildid',

            'uudised' => 'uudised',
            'sein/uudised' => 'uudised',

            'reisikaaslased' => 'reisikaaslased',
            'sein/reisikaaslased' => 'reisikaaslased',

            'ostmuuk' => 'foorum/ost-muuk',

            'soodsad_lennupiletid' => 'odavad-lennupiletid',
            'lendude_sooduspakkumised' => 'odavad-lennupiletid',

            'foorum' => 'foorum/uldfoorum',
            'sein/foorum' => 'foorum/uldfoorum',

            'reisipakkumised' => '/',
            'sein/reisipakkumised' => '/',
            'sein/turg' => '/',

            'sein' => '/',

        ];

        $path = $part2 ? $part1.'/'.$part2 : $part1;

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
                'destination.showSlug', [
                    $destination->slug,
                ], 301);
        }

        if ($topic = Topic::find($tid)) {
            return redirect()->route(
                'forum.index', [
                    'topic' => $topic,
                ], 301);
        }

        if ($carrier = Carrier::find($tid)) {
            return redirect()->route(
                'flight.index', [
                    'carrier' => $carrier,
                ], 301);
        }

        return redirect()->route(
            'content.index', [
                'forum',
            ], 301);
    }

    public function redirectTaxonomyBlurb($blurb, $tid)
    {
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
                'destination.showSlug', [
                    $destination->slug,
                ], 301);
        }

        abort(404);
    }

    public function redirectDestinationBlurb($blurb, $title)
    {
        return $this->redirectDestination($title);
    }

    public function redirectDestinationBlurb2($blurb, $blurb2, $title)
    {
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
                    'destination.showSlug', [
                        $destination->slug,
                    ], 301);
            }

            if ($topic = Topic::find($alias->aliasable_id)) {
                return redirect()->route(
                    'forum.index', [
                        'topic' => $topic,
                    ], 301);
            }

            return redirect()->route('forum.index', 301);
        }

        abort(404);
    }

    public function redirectCategoryBlurb($blurb, $part1, $part2, $part3 = null, $part4 = null)
    {
        return $this->redirectCategory($part1, $part2, $part3, $part4);
    }

    public function redirectUser($id)
    {
        return redirect()->route('user.show', [$id], 301);
    }
}
