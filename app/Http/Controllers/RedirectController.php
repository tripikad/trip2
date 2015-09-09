<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Content;
use App\Destination;
use App\Topic;

class RedirectController extends Controller
{

    public function redirectNode($node_id)
    {
        
        if ($content = Content::find($node_id)) {
            return redirect()->route(
                'content.show', [
                    $content->type,
                    $content
                ], 301);
        }

        abort(404);
    
    }  

    public function redirectContent($path)
    {

        $alias = \DB::table('aliases')
            ->wherePath('content/' . $path)
            ->first();

            dump('content/'. $path);

        if ($alias) {


            $content = Content::find($alias->aliasable_id);
            return redirect()
                ->route('content.show', [
                    $content->type,
                    $content
                ], 301);
        
        }

        abort(404);

    }


    public function redirectTaxonomy($tid)
    {

        $alias = \DB::table('aliases')
            ->wherePath('taxonomy/tid/' . $tid)
            ->first();

        $tid = $alias ? $alias->tid : $tid;

        if ($destination = Destination::find($tid)) {
            
            return redirect()->route(
                'destination.index', [
                    $destination
                ], 301);
        
        }

        if ($topic = Topic::find($tid)) {

            return redirect()->route(
                'content.index', [
                    'forum',
                    'topic' => $topic
                ], 301);
        
        }

        if ($carrier = Carrier::find($term_id)) {

            return redirect()->route(
                'content.index', [
                    'flight',
                    'carrier' => $carrier
                ], 301);
        
        }

        abort(404);
    
    }  

    public function redirectDestination($title)
    {

        $alias = \DB::table('aliases')
            ->wherePath('sihtkoht/' . $title)
            ->first();

        if ($alias) {

            $destination = Destination::find($alias->aliasable_id);
        
            return redirect()->route(
                'destination.index', [
                    $destination
                ], 301);
        
        }

        abort(404);

    }

    public function redirectCategory($part1, $part2, $part3 = null, $part4 = null)
    {

        $path = collect(['category', $part1, $part2, $part3, $part4])
            ->reject(function ($name) { return empty($name); })
            ->implode('/');

        $alias = \DB::table('aliases')
            ->wherePath($path)
            ->first();

        if ($alias) {

            if ($destination = Destination::find($alias->aliasable_id)) {

                return redirect()->route(
                    'destination.index', [
                        $destination
                    ], 301);
            
            }

            if ($topic = Topic::find($alias->aliasable_id)) {

                return redirect()->route(
                    'content.index', [
                        'forum',
                        'topic' => $topic
                    ], 301);
            
            }
        
        }

        abort(404);

    }

}