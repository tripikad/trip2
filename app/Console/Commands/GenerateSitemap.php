<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App;
use \App\User;
use \App\Destination;
use \App\Content;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    public function handle()
    {
        $this->line('Generating sitemap');

        // create new sitemap object
        $sitemap = App::make('sitemap');
        $sitemapCounter = 0;

        // Generate index pages sitemap
        $types = [
            'frontpage.index',
            'flight.index',
            'forum.index',
            'expat.index',
            'buysell.index',
            'news.index',
            'photo.index',
            'shortnews.index',
            //'sponsored.index',
            'travelmate.index',
            'register.form',
            'login.form',
            'reset.apply.form',
        ];

        foreach ($types as $route) {
            $sitemap->add(route($route));
        }

        $sitemap->store('xml', 'sitemap-'.$sitemapCounter);
        $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'));
        $sitemap->model->resetItems();

        // Generate destinations sitemap
        //$sitemapCounter++;
        $destinations = Destination::get();
        foreach ($destinations as $destination) {
            $sitemap->add(route('destination.slug', [$destination->slug]));
        }

        $sitemap->store('xml', 'sitemap-'.$sitemapCounter);
        $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'));
        $sitemap->model->resetItems();

        // Generate users sitemap
        $sitemapCounter++;
        $users = User::where('verified', 1)
            ->get();

        foreach ($users as $user) {
            $sitemap->add(route('user.show', [$user->id]));
        }

        $sitemap->store('xml', 'sitemap-'.$sitemapCounter);
        $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'));
        $sitemap->model->resetItems();

        $sitemapCounter++;

        Content::whereNotIn('type', ['internal'])
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->chunk(config('sitemap.items_per_sitemap'), function ($contents) use ($sitemap, &$sitemapCounter) {
                foreach ($contents as $content) {
                    if ($content->type == 'static') {
                        $sitemap->add(route($content->type.'.'.$content->id), $content->updated_at);
                    } else {
                        $sitemap->add(route($content->type.'.show', [$content->slug]), $content->updated_at);
                    }
                }

                // generate new sitemap file
                $sitemap->store('xml', 'sitemap-'.$sitemapCounter);
                // add the file to the sitemaps array
                $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'));
                // reset items array (clear memory)
                $sitemap->model->resetItems();

                // count generated sitemap
                $sitemapCounter++;
            });

        // generate new sitemapindex that will contain all generated sitemaps above
        $sitemap->store('sitemapindex', 'sitemap');

        $this->line('Sitemap done');
    }
}
