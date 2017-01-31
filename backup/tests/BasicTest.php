<?php


class BasicTest extends TestCase
{
    public function test_seeing_frontpage_without_logging_in()
    {
        $this->visit('/')
             ->see(config('site.name'));
    }

    public function test_seeing_content_pages_without_logging_in()
    {
        $pages = [
            '/',
            '/odavad-lennupiletid',
            '/reisikaaslased',
            '/foorum/uldfoorum',
            '/foorum/ost-muuk',
            '/foorum/elu-valimaal',
            '/uudised',
            '/reisiblogid',
            '/reisipildid',
            '/tripist',
            '/user/1',
            '/sihtkoht/1',
        ];

        foreach ($pages as $page) {
            $this->visit($page)
                ->see(config('site.name'));
        }
    }
}
