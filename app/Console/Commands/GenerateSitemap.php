<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    public function handle()
    {
        $this->line('Generating sitemap');

        // create new sitemap object
        $sitemap = \App::make('sitemap');
        $sitemapCounter = 0;

        $destinations = \App\Destination::get();
        foreach ($destinations as $destination) {
            $sitemap->add(route('destination.slug', [$destination->slug]), \Carbon\Carbon::yesterday(), 0.1, 'daily');
        }

        $sitemap->store('xml', 'sitemap-'.$sitemapCounter);
        $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'));
        $sitemap->model->resetItems();

        $sitemapCounter++;

        \App\Content::whereNotIn('type', ['photo', 'static', 'internal'])
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->chunk(config('sitemap.items_per_sitemap'), function ($contents) use ($sitemap, &$sitemapCounter) {
                foreach ($contents as $content) {
                    $sitemap->add(route($content->type.'.show', [$content->slug]), $content->updated_at, 0.1, 'daily');
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
