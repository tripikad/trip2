<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Offer;
use App\Destination;
use Carbon\Carbon;

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

        $this->info("\nImporting content\n");

        $offers->each(function ($o) use ($startDestination) {
            $this->line($o->title);

            $endDestination = Destination::where('name', $o->destination)->first();

            $data = [
                'user_id' => 7288983, // andresk
                'title' => $o->title,
                'style' => $o->style,
                'price' => $o->price,
                'start_at' => Carbon::now()->addMonth(),
                'end_at' => Carbon::now()
                    ->addMonth()
                    ->addWeek(),
                'start_destination_id' => $startDestination->id,
                'end_destination_id' => $endDestination->id,

                'data' => [
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
                            'type' => $o->hoteltype
                        ]
                    ]
                ],
                'status' => 1
            ];

            if ($offer = Offer::findOrFail($o->id)) {
                $offer->update($data);
            } else {
                Offer::create(
                    collect($data)
                        ->put('id', $o->id)
                        ->toArray()
                );
            }
        });
    }
}
