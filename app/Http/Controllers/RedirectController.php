<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Imageconv;

use App\Content;
use App\Destination;
use App\Topic;
use App\Carrier;


class RedirectController extends Controller
{
	public function redirectContent($path)
    {
        $alias = \DB::table('content_alias')
            ->whereAlias('content/' . $path)
            ->first();

        if ($alias) {
            $content = Content::find($alias->content_id);
            return redirect('content/' . $content->type . '/' . $alias->content_id, 301);
        }

        abort(404);
    }

	public function redirectTerm($term_id)
    {
        if ($destination = Destination::find($term_id)) {
        	return redirect()->route(
            'destination.index',
            [$destination]      
        	);
        }

        if ($topic = Topic::find($term_id)) {
        	return redirect()->route(
            'content.index',
            [
            'forum',
            'topic' => $topic
            ]
            );
        }

        if ($carrier = Carrier::find($term_id)) {
        	return redirect()->route(
            'content.index',
            [
            'flight',
            'carrier' => $carrier
            ]
            );
        }

        abort(404);
    }

    public function redirectNode($node_id)
    {
        if ($content = Content::find($node_id)) {
        	return redirect()->route(
            'content.show',
            [
            $content->type,
            $content
            ]      
        	);
        }

        abort(404);
    }    
}