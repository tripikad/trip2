<?php


class StyleguideTest extends TestCase
{
    public function test_seeing_styleguide_without_logging_in()
    {
        $this->visit('/styleguide')
             ->see('Styleguide');
    }
}
