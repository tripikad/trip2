<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Content;
use Feed;

class AtomController extends Controller
{

    public function index(Request $request)
    {
        $feed = Feed::make();

        //cache the feed in minutes
        $feed->setCache(config('site.cache.atom'));

        if (!$feed->isCached())
        {   
            $feed->title = config('site.name');
            $feed->description = trans('content.atom.description');
            //$feed->logo = 'http://trip.ee/public/logo.jpg';
            $feed->link = url('atom');
            $feed->setDateFormat('timestamp'); // 'datetime', 'timestamp' or 'carbon'
            //$feed->lang = 'en';
            //$feed->setShortening(true); // true or false
            //$feed->setTextLimit(100); // maximum length of description text

            $news = Content::whereType('news')->whereStatus(1)->latest()->take(10)->get();

            //params: title, author, url, created_at, description, content
            foreach ($news as $n) {
                $url = url('content/'. $n->type . '/' . $n->id);
                $feed->add($n->title, null, $url, $n->created_at, null, $n->body);
            }
        }

        return $feed->render('atom');

    }

    

}
