<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\User;

class OfferClear extends Command
{
    protected $signature = 'offer:clear';

    protected $description = 'Clears all offers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // @LAUNCH
        // if (env('OFFER_ENABLED')) {
        //     $this->info("\nOffers are live, they can longer cleared");
        //     die();
        // }

        if ($this->confirm('This command removes all offer content. Do you want to continue?')) {
            DB::table('offers')->truncate();
            DB::table('bookings')->truncate();
            DB::table('offer_destination')->truncate();

            $user = User::whereCompany(true)->update(['company' => false]);

            $this->info("\nOffer content cleared\n");
        }
    }
}
