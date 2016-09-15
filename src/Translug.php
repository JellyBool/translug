<?php
namespace JellyBool\Translug;

use GuzzleHttp\Client;

/**
 * Class Translug
 *
 * @package JellyBool\Translug
 */
class Translug
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * Translug constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function translate($text)
    {
        $translator = new Translation(new Client(), $this->config);

        return $translator->translate($text);
    }

    /**
     * @param $text
     * @return string
     */
    public function translug($text)
    {
        return $this->sluggable($this->translate($text));
    }

    /**
     * @param $title
     * @param string $separator
     * @return string
     */
    private function sluggable($title, $separator = '-')
    {
        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';

        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

        return trim($title, $separator);
    }
}