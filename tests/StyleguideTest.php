<?php


class StyleguideTest extends TestCase
{
    public function test_seeing_styleguide_without_logging_in()
    {
        $this->markTestSkipped();

        $this->visit('/styleguide')
             ->see('Styleguide');
    }
}
