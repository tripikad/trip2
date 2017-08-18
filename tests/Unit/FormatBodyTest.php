<?php

namespace Tests\Unit;

use App\Image;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatBodyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_body_text_is_formatted()
    {
        $cases = [
            [
                '**Hello** World',
                '<p><strong>Hello</strong> World</p>',
                'Double asterisks are converted to HTML strong tag',
            ],
            [
                '_Hello_ World',
                '<p><em>Hello</em> World</p>',
                'Underlines are converted to HTML em tag',
            ],
            [
                "* Hello\n* World",
                "<ul>\n<li>Hello</li>\n<li>World</li>\n</ul>",
                '* are converted to unordered lists',
            ],
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }

    public function test_body_links_are_formatted()
    {
        $cases = [
            [
                'Hello <a href="http://tc.tradetracker.net/?c=23368&m=12&a=258453&u=%2Fflightsearch%2F%3FSearch%3Dtrue%26TripType%3D2%26SegNo%3D2%26SO0%3DTLL%26SD0%3DHKG%26SDP0%3D25-09-2017%26SO1%3DHKG%26SD1%3DTLL%26SDP1%3D06-10-2017%26AD%3D1%26TK%3DECO%26DO%3Dfalse%26NA%3Dfalse%26currency%3DEUR">Tradetracker</a>',
                '<p>Hello <a href="http://tc.tradetracker.net/?c=23368&m=12&a=258453&u=%2Fflightsearch%2F%3FSearch%3Dtrue%26TripType%3D2%26SegNo%3D2%26SO0%3DTLL%26SD0%3DHKG%26SDP0%3D25-09-2017%26SO1%3DHKG%26SD1%3DTLL%26SDP1%3D06-10-2017%26AD%3D1%26TK%3DECO%26DO%3Dfalse%26NA%3Dfalse%26currency%3DEUR" target="_blank">Tradetracker</a></p>',
                'Links are OK',
            ],
            [
                'Hello http://google.com',
                '<p>Hello <a href="http://google.com" target="_blank">http://google.com</a></p>',
                'External URLs are converted to HTML link tags opening in new windoww',
            ],
            [
                'Hello <a href="http://google.com">Google</a>',
                '<p>Hello <a href="http://google.com" target="_blank">Google</a></p>',
                'External HTML link tags are kept as is, opening in a new window',
            ],
            [
                'Hello http://trip.ee',
                '<p>Hello <a href="http://trip.ee">http://trip.ee</a></p>',
                'Internal URLs are converted to HTML link tags',
            ],
            [
                'Hello <a href="http://trip.ee">Trip</a>',
                '<p>Hello <a href="http://trip.ee">Trip</a></p>',
                'Internal HTML link tags are kept as is',
            ],
            [
                'Hello [Google](http://google.com)',
                '<p>Hello <a href="http://google.com" target="_blank">Google</a></p>',
                'External Markdown links should be converted to HTML links opening in a new window',
            ],
            [
                'Hello trip.ee',
                '<p>Hello <a href="http://trip.ee">http://trip.ee</a></p>',
                'Internal links without http(s) and www are converted into HTML links',
            ],
            [
                'Hello google.com',
                '<p>Hello <a href="http://google.com" target="_blank">http://google.com</a></p>',
                'External link without http(s) and www are converted into HTML links',
            ],
            [
                'Hello www.trip.ee',
                '<p>Hello <a href="http://www.trip.ee">http://www.trip.ee</a></p>',
                'Internal links without http(s) are converted into HTML links',
            ],
            [
                'Hello www.google.com',
                '<p>Hello <a href="http://www.google.com" target="_blank">http://www.google.com</a></p>',
                'External link without http(s) are converted into HTML links',
            ],
            [
                'Hello [Trip](trip.ee)',
                '<p>Hello <a href="http://trip.ee">Trip</a></p>',
                'Internal Markdown links without http(s) should be converted to HTML links opening in a new window',
            ],
            [
                'Hello [Google](google.com)',
                '<p>Hello <a href="http://google.com" target="_blank">Google</a></p>',
                'External Markdown links without http(s) should be converted to HTML links opening in a new window',
            ],

        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }

    public function test_body_images_are_formatted()
    {
        $image = Image::create(['filename' => str_random(6).'.jpg']);

        $cases = [
            [
                'Hello [['.$image->id.']]',
                '<p>Hello <img src="'.$image->preset('large').'" /></p>',
                'Existing image references should be replaced with HTML image tag',
            ],
            [
                'Hello [[0]]',
                '<p>Hello [[0]]</p>',
                'Non-existing image references should be kept as is',
            ],
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }

    public function test_calendar_is_formatted()
    {
        $cases = [
            [
                "[[\nJanuary:\n- First\n]]",
                component('FlightCalendar')
                    ->with('months', ['January' => [format_body('First')]])
                    ->render(),
                'Single calendar is formatted',
            ],
            [
                "[[\nJanuary:\n- First\n]]\n[[\nFebruary:\n- Second\n]]",
                component('FlightCalendar')
                    ->with('months', ['January' => [format_body('First')]])
                    ->render()
                ."\n"
                .component('FlightCalendar')
                    ->with('months', ['February' => [format_body('Second')]])
                    ->render(),
                'Multiple calendars are formatted',
            ],

        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }
}
