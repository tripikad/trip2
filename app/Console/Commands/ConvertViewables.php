<?php

namespace App\Console\Commands;

use App\Content;
use App\Viewable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class ConvertViewables extends Command
{
  protected $signature = 'convert:viewables';

  protected $description = 'Converts activities table values to viewables table values';

  protected $forum_types = ['forum', 'buysell', 'expat', 'internal', 'misc'];

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info("\nConverting activities\n");
    DB::disableQueryLog();
    $content_type = 'App\Content';

    $count = Content::whereIn('type', $this->forum_types)->count();
    $progressBar = new ProgressBar($this->output, $count);
    $progressBar->start();

    Content::whereIn('type', $this->forum_types)
      ->orderBy('id', 'DESC')
      ->chunk(100, function ($contents) use ($content_type, $progressBar) {
        $data = new Collection();
        foreach ($contents as $content) {
          $views_count = $content->views_count_old;

          if ($views_count) {
            $data->push([
              'viewable_id' => $content->id,
              'viewable_type' => $content_type,
              'count' => $views_count
            ]);

            /*Viewable::create([
            'viewable_id' => $content->id,
            'viewable_type' => $content_type,
            'count' => $views_count
          ]);*/
          }
        }

        Viewable::insert($data->toArray());

        $progressBar->advance(100);
      });

    $progressBar->finish();
    $this->info("\nDONE!\n");
  }
}
