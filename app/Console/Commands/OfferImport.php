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
        // @LAUNCH Remove

        if ($this->confirm('This command imports new offers. Do you want to continue?')) {
            $sheet_id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';
            $offers = google_sheet($sheet_id);

            $startDestination = Destination::where('name', 'Tallinn')->first();

            $this->info("\nImporting content\n");

            $offers->each(function ($o) use ($startDestination) {
                $this->line($o->title);

                $endDestination = Destination::where('name', $o->destination)->first();

                $user = User::findOrFail($o->userid);
                $user->update(['company' => true]);

                $start_at = Carbon::createFromFormat('d.m.Y', trim($o->from));
                $end_at = Carbon::createFromFormat('d.m.Y', trim($o->to));

                $data = [
                    'user_id' => $o->userid,
                    'title' => $o->title,
                    'style' => $o->style,
                    'start_at' => $start_at,
                    'end_at' => $end_at,
                    'data' => [
                        'price' => $o->style == 'package' ? '' : $o->price,
                        'guide' => $o->guide,
                        'size' => $o->people,
                        'description' => $o->description,
                        'url' => $o->url,
                        'accommodation' => $o->accommodation
                            ? '- ' . collect(explode(',', $o->accommodation))->implode("\n- ")
                            : '',
                        'included' => $o->included ? '- ' . collect(explode(',', $o->included))->implode("\n- ") : '',
                        'notincluded' => $o->notincluded
                            ? '- ' . collect(explode(',', $o->notincluded))->implode("\n- ")
                            : '',
                        'extras' => $o->extras ? '- ' . collect(explode(',', $o->extras))->implode("\n- ") : '',
                        'flights' => false,
                        'transfer' => false,
                        'hotels' => [
                            [
                                'name' => $o->hotel,
                                'type' => $o->hoteltype,
                                'rating' => intval(only_numbers($o->hotelrating)),
                                'price' => $o->style == 'package' ? $o->hotelprice : ''
                            ],
                            [
                                'name' => $o->hotel . ' Economy',
                                'type' => $o->hoteltype,
                                'rating' => intval(only_numbers($o->hotelrating)) + 1,
                                'price' => $o->style == 'package' ? '200' : ''
                            ],
                            [
                                'name' => $o->hotel . ' Lux',
                                'type' => $o->hoteltype,
                                'rating' => intval(only_numbers($o->hotelrating)) - 2,
                                'price' => $o->style == 'package' ? '1000' : ''
                            ],
                            [
                                'name' => $o->hotel . ' Deluxe Plus',
                                'type' => $o->hoteltype,
                                'rating' => intval(only_numbers($o->hotelrating)) + 2,
                                'price' => $o->style == 'package' ? '3500' : ''
                            ],
                            [
                                'name' => $o->hotel . ' Millionaire Suite',
                                'type' => $o->hoteltype,
                                'rating' => intval(only_numbers($o->hotelrating)) + 3,
                                'price' => $o->style == 'package' ? '10000' : ''
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
                    collect([$endDestination->id])->mapWithKeys(function ($key) {
                        return [$key => ['type' => 'end']];
                    })
                );
            });
        }
    }
}
