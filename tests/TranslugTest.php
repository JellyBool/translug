<?php

class TranslugTest extends PHPUnit_Framework_TestCase
{
    protected $translug;

    public function setUp()
    {
        $this->translug = new \JellyBool\Translug\Translation(new \GuzzleHttp\Client());
    }

    /** @test */
    public function it_check_the_english_title_translated_text()
    {
        $english = $this->translug->translate('How to install Laravel');

        $this->assertEquals('How to install Laravel',$english);
    }

    /** @test */
    public function it_check_the_english_title_slug_text()
    {
        $english = $this->translug->translug('How to install Laravel');

        $this->assertEquals('how-to-install-laravel',$english);
    }

}