<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Offer;
use App\User;
use App\Destination;

class OfferImport extends Command
{
    protected $signature = 'offer:import';

    protected $description = 'Import offers from Google Sheets';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sheet_id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';
        $offers = google_sheet($sheet_id);

        $startDestination = Destination::where('name', 'Tallinn')->first();
        $moreDestination = Destination::where('name', 'Barcelona')->first();

        $this->info("\nImporting content\n");

        $offers->each(function ($o) use ($startDestination, $moreDestination) {
            $this->line($o->title);

            $endDestination = Destination::where('name', $o->destination)->first();

            $user = User::findOrFail($o->userid);
            $user->update(['company' => true]);

            $data = [
                'user_id' => $o->userid,
                'title' => $o->title,
                'style' => $o->style,
                'start_at' => Carbon::now()->addMonth(),
                'end_at' => Carbon::now()
                    ->addMonth()
                    ->addWeek(),

                'data' => [
                    'price' => $o->style == 'package' ? '' : $o->price,
                    'guide' => $o->guide,
                    'size' => $o->people,
                    'accommodation' => '',
                    'included' => $o->included,
                    'extras' => '',
                    'description' => '',
                    'flights' => false,
                    'transfer' => false,
                    'hotels' => [
                        [
                            'name' => $o->hotel,
                            'type' => $o->hoteltype,
                            'rating' => 5,
                            'price' => $o->style == 'package' ? '1000' : ''
                        ]
                    ]
                ],
                'status' => $o->status
            ];

            $offer = Offer::create(
                collect($data)
                    ->put('id', $o->id)
                    ->toArray()
            );

            $offer->startDestinations()->attach(
                collect([$startDestination->id])->mapWithKeys(function ($key) {
                    return [$key => ['type' => 'start']];
                })
            );

            $offer->endDestinations()->attach(
                collect([$endDestination->id, $moreDestination->id])->mapWithKeys(function ($key) {
                    return [$key => ['type' => 'end']];
                })
            );
        });
    }
}
