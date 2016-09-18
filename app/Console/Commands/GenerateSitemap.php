<?php

namespace App\Console\Commands;

use App\Content;
use App\Destination;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Generating sitemap');

        /** @var Sitemap $sitemap */
        $sitemap = SitemapGenerator::create(config('app.url'))->getSitemap();

        Destination::chunk(200, function ($destinations) use ($sitemap) {
            foreach ($destinations as $destination) {
                $sitemap->add(Url::create(route('destination.slug', $destination->slug))
                    ->setLastModificationDate(Carbon::today()->modify('-1 month'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.1));
            }
        });

        Content::whereNotIn('type', ['photo', 'static', 'internal'])
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->take(50000)
            ->chunk(200, function ($contents) use ($sitemap) {
            foreach ($contents as $content) {
                $sitemap->add(Url::create(route($content->type.'.show', $content->slug))
                        ->setLastModificationDate(Carbon::yesterday())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.1));
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->line('Done');
    }
}