<?php

use Carbon\Carbon;
use App\NewsletterType;
use Illuminate\Database\Seeder;

class NewsletterLetterContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsletter_types = NewsletterType::all();

        $content = [];

        foreach ($newsletter_types as &$newsletter_type) {
            if ($newsletter_type->type == 'flight') {
                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Vaata pakkumist ja sobivuse korral broneeri piletid:</h2>',
          'sort_order' => 1,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[the_flight]]',
          'sort_order' => 2,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];
            } elseif ($newsletter_type->type == 'flight_general') {
                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Siin on 3 viimast lennupakkumist, mis võivad Sulle huvi pakkuda:</h2>',
          'sort_order' => 1,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:flight|take:3]]',
          'sort_order' => 2,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];
            } elseif ($newsletter_type->type == 'weekly') {
                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Viimased lennupakkumised:</h2>',
          'sort_order' => 1,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:flight|take:3]]',
          'sort_order' => 2,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Tripikad räägivad</h2>',
          'sort_order' => 3,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:forum,buysell,expat|take:5]]',
          'sort_order' => 4,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Reisikaaslaste otsingud</h2>',
          'sort_order' => 5,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:travelmate|take:3]]',
          'sort_order' => 6,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Viimased uudised</h2>',
          'sort_order' => 7,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:news|take:2]]',
          'sort_order' => 8,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Viimased lühiuudised</h2>',
          'sort_order' => 9,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:shortnews|take:2]]',
          'sort_order' => 10,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];
            } elseif ($newsletter_type->type == 'long_time_ago') {
                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Populaarsemad lennupakkumised:</h2>',
          'sort_order' => 1,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:flight|take:3|order_by:pop]]',
          'sort_order' => 2,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Populaarsemad teemad foorumis</h2>',
          'sort_order' => 3,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:forum,buysell,expat|take:5|order_by:pop]]',
          'sort_order' => 4,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Populaarsemad reisikaaslaste otsingud</h2>',
          'sort_order' => 5,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:travelmate|take:3|order_by:pop]]',
          'sort_order' => 6,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '<h2>Populaarsed uudised</h2>',
          'sort_order' => 7,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];

                $content[] = [
          'newsletter_type_id' => $newsletter_type->id,
          'body' => '[[type:news,shortnews|take:4|order_by:pop]]',
          'sort_order' => 8,
          'visible_from' => null,
          'visible_to' => null,
          'updated_at' => Carbon::now(),
          'created_at' => Carbon::now()
        ];
            }
        }

        DB::table('newsletter_letter_contents')->insert($content);
    }
}
