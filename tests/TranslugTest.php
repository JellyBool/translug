<?php

class TranslugTest extends PHPUnit_Framework_TestCase
{
    protected $translug;

    protected $translator;

    public function setUp()
    {
        $this->translator = new \JellyBool\Translug\Translation(new \GuzzleHttp\Client());
        $this->translug = new JellyBool\Translug\Translug();
    }

    /** @test */
    public function it_test_the_english_title_translated_text()
    {
        $translatedText = $this->translator->translate('How to install Laravel');

        $this->assertEquals('How to install Laravel', $translatedText);
    }

    /** @test */
    public function it_test_the_english_title_slug_text()
    {
        $slugText = $this->translator->translug('How to install Laravel');

        $this->assertEquals('how-to-install-laravel', $slugText);
    }

    /** @test */
    public function it_test_the_english_title_translated_text_with_slug_class()
    {
        $tranlatedText = $this->translug->translate('How to install Laravel');

        $this->assertEquals('How to install Laravel', $tranlatedText);
    }

    /** @test */
    public function it_test_the_english_title_slug_text_with_slug_class()
    {
        $slugText = $this->translug->translug('How to install Laravel');

        $this->assertEquals('how-to-install-laravel', $slugText);
    }

    /** @test */
    public function it_test_the_slug_class_set_config()
    {
        $config = ['key' => 1533000, 'keyfrom' => 'laravist'];
        $this->translug->setConfig($config);

        $this->assertEquals(['key' => 1533000, 'keyfrom' => 'laravist'], $this->translug->getConfig());
    }
}
