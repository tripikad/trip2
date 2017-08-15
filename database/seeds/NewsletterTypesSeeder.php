<?php

use Illuminate\Database\Seeder;

class NewsletterTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('newsletter_types')->insert([
            [
                'subject' => 'Mis toimus Tripis möödunud nädalal?',
                'type' => 'weekly',
                'send_days_after' => 7,
                'check_user_active_at' => false,
                'last_sent_at' => null,
                'send_at' => '2017-08-13 22:00:00',
                'active' => true,
            ],
            [
                'subject' => 'Pole Sind ammu näinud',
                'type' => 'long_time_ago',
                'send_days_after' => 30,
                'check_user_active_at' => true,
                'last_sent_at' => null,
                'send_at' => null,
                'active' => true,
            ],
            [
                'subject' => 'Leidsime Sulle sobiva lennupakkumise sihtkohta %destination_name',
                'type' => 'flight',
                'send_days_after' => null,
                'check_user_active_at' => false,
                'last_sent_at' => null,
                'send_at' => null,
                'active' => true,
            ],
            [
                'subject' => 'Siin on kõige uuemad lennupakkumised!',
                'type' => 'flight_general',
                'send_days_after' => 3,
                'check_user_active_at' => false,
                'last_sent_at' => null,
                'send_at' => null,
                'active' => true,
            ],
        ]);
    }
}
