<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Offer;

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

        $this->info("\nImporting content\n");

        $offers->each(function ($o) {
            $this->line($o->title);
            $data = [
                'user_id' => 12,
                'title' => $o->title,
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
                'status' => 0
            ];

            if ($offer = Offer::find($o->id)) {
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
