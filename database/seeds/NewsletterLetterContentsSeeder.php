<?php

use Illuminate\Database\Seeder;
use App\NewsletterType;
use Carbon\Carbon;

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
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Vaata pakkumist ja sobivuse korral broneeri piletid:</h2>',
                    'sort_order' => 1,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'flight_by_destination_id',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 2,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];
            } elseif ($newsletter_type->type == 'flight_general') {
                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Siin on 3 viimast lennupakkumist, mis võivad Sulle huvi pakkuda:</h2>',
                    'sort_order' => 1,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'last_0_flight(3)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 2,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];
            } elseif ($newsletter_type->type == 'weekly') {
                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Viimased lennupakkumised:</h2>',
                    'sort_order' => 1,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'last_0_flight(3)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 2,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Tripikad räägivad</h2>',
                    'sort_order' => 3,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'last_0_forum|buysell|expat(5)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 4,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Reisikaaslaste otsingud</h2>',
                    'sort_order' => 5,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'last_0_travelmate(3)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 6,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Viimased uudised</h2>',
                    'sort_order' => 7,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'last_0_news(2)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 8,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Viimased lühiuudised</h2>',
                    'sort_order' => 9,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'last_0_shortnews(2)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 10,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];
            } elseif ($newsletter_type->type == 'long_time_ago') {
                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Populaarsemad lennupakkumised:</h2>',
                    'sort_order' => 1,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'pop_0_flight(3)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 2,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Populaarsemad teemad foorumid</h2>',
                    'sort_order' => 3,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'pop_0_forum|buysell|expat(5)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 4,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Populaarsemad reisikaaslaste otsingud</h2>',
                    'sort_order' => 5,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'pop_0_travelmate(3)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 6,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => '',
                    'content_id' => null,
                    'content' => '<h2>Populaarsed uudised</h2>',
                    'sort_order' => 7,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                $content[] = [
                    'newsletter_type_id' => $newsletter_type->id,
                    'dynamic_content' => 'pop_0_news|shortnews(4)',
                    'content_id' => null,
                    'content' => null,
                    'sort_order' => 8,
                    'visible_from' => null,
                    'visible_to' => null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];
            }
        }

        DB::table('newsletter_letter_contents')->insert($content);
    }
}
