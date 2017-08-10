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
            ]

        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }
}
